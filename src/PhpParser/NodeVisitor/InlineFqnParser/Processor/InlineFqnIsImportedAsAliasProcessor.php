<?php

declare(strict_types=1);

namespace Jerowork\ClassDependenciesParser\PhpParser\NodeVisitor\InlineFqnParser\Processor;

use Jerowork\ClassDependenciesParser\Fqn;
use Jerowork\ClassDependenciesParser\ImportedFqn;
use Jerowork\ClassDependenciesParser\ClassDependencies;
use PhpParser\Node;
use PhpParser\Node\Name;

final class InlineFqnIsImportedAsAliasProcessor implements InlineFqnProcessor
{
    use CreateInlineFqnBasedOnImportedFqnTrait;

    public function shouldProcess(Node $parent, Name $name, ClassDependencies $classDependencies): bool
    {
        return $classDependencies->getImportedFqnHavingAlias($name->parts[0]) !== null;
    }

    public function process(Node $parent, Name $name, ClassDependencies $classDependencies): ?Fqn
    {
        /** @var ImportedFqn $importedFqn */
        $importedFqn = $classDependencies->getImportedFqnHavingAlias($name->parts[0]);

        return $this->createInlineFqnBasedOnImportedFqn($importedFqn, $name);
    }
}
