<?php

declare(strict_types=1);

namespace Jerowork\ClassDependenciesParser\PhpParser\NodeVisitor;

use Jerowork\ClassDependenciesParser\Fqn;
use Jerowork\ClassDependenciesParser\ImportedFqn;
use Jerowork\ClassDependenciesParser\ClassDependencies;
use PhpParser\Node;
use PhpParser\Node\Stmt\GroupUse;
use PhpParser\Node\Stmt\Use_;
use PhpParser\NodeVisitorAbstract;

final class ParseImportedFqnNodeVisitor extends NodeVisitorAbstract
{
    public function __construct(
        private readonly ClassDependencies $classDependencies,
    ) {
    }

    public function enterNode(Node $node): int|Node|null
    {
        if (!$node instanceof Use_ && !$node instanceof GroupUse) {
            return parent::enterNode($node);
        }

        $prefix = $node instanceof GroupUse ? sprintf('%s\\', $node->prefix) : '';

        foreach ($node->uses as $use) {
            $this->classDependencies->addImportedFqn(new ImportedFqn(
                new Fqn($prefix . $use->name),
                true,
                $use->alias !== null ? (string) $use->alias : null,
            ));
        }

        return parent::enterNode($node);
    }
}
