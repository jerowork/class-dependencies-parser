<?php

declare(strict_types=1);

namespace Jerowork\ObjectDependenciesParser\PhpParser\NodeVisitor;

use Jerowork\ObjectDependenciesParser\Fqn;
use Jerowork\ObjectDependenciesParser\ImportedFqn;
use Jerowork\ObjectDependenciesParser\ObjectDependencies;
use PhpParser\Node;
use PhpParser\Node\Expr\ConstFetch;
use PhpParser\Node\Name;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Stmt\GroupUse;
use PhpParser\Node\Stmt\Namespace_;
use PhpParser\Node\Stmt\UseUse;
use PhpParser\NodeVisitorAbstract;

final class ParseInlineFqnNodeVisitor extends NodeVisitorAbstract
{
    public function __construct(
        private readonly ObjectDependencies $objectDependencies,
    ) {
    }

    public function enterNode(Node $node): int|Node|null
    {
        if (!$node instanceof Name) {
            return parent::enterNode($node);
        }

        $parent = $node->getAttribute('parent');

        if ($parent instanceof ConstFetch
            || $parent instanceof UseUse
            || $parent instanceof GroupUse
            || $parent instanceof Namespace_
        ) {
            return parent::enterNode($node);
        }

        $inlineFqn = $this->createInlineFqnBasedOnNodeName($node);
        if ($inlineFqn !== null) {
            $this->objectDependencies->addInlineFqn($inlineFqn);
        }

        return parent::enterNode($node);
    }

    private function createInlineFqnBasedOnNodeName(Name $name): ?Fqn
    {
        // Name is already a FQN
        if ($name instanceof FullyQualified) {
            $fqn = Fqn::createFromParts($name->parts);

            if ($this->objectDependencies->hasImportedFqn($fqn)) {
                return null;
            }

            return $fqn;
        }

        // Verify if Name is imported
        $importedFqn = $this->objectDependencies->getImportedFqnHavingLastPart($name->parts[0]);
        if ($importedFqn !== null) {
            return $this->createInlineFqnBasedOnImportedFqn($importedFqn, $name);
        }

        // Verify if Name is imported as alias
        $importedFqn = $this->objectDependencies->getImportedFqnHavingAlias($name->parts[0]);
        if ($importedFqn !== null) {
            return $this->createInlineFqnBasedOnImportedFqn($importedFqn, $name);
        }

        // Name is within same namespace as main object
        /** @var Fqn $objectFqn */
        $objectFqn = $this->objectDependencies->getFqn();

        return new Fqn(sprintf('%s\%s', $objectFqn->getFullFqnWithoutLastPart(), $name));
    }

    private function createInlineFqnBasedOnImportedFqn(ImportedFqn $importedFqn, Name $name): ?Fqn
    {
        if (count($name->parts) === 1) {
            return null;
        }

        // Set importedFqn as non-object (folder namespace)
        $importedFqn->isNotObject();

        $nameParts = $name->parts;
        array_shift($nameParts);

        return new Fqn(sprintf('%s\%s', $importedFqn->fqn, implode('\\', $nameParts)));
    }
}
