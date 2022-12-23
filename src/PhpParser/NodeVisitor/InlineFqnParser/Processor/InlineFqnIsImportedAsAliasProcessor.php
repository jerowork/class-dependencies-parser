<?php

declare(strict_types=1);

namespace Jerowork\ObjectDependenciesParser\PhpParser\NodeVisitor\InlineFqnParser\Processor;

use Jerowork\ObjectDependenciesParser\Fqn;
use Jerowork\ObjectDependenciesParser\ObjectDependencies;
use PhpParser\Node;
use PhpParser\Node\Name;

final class InlineFqnIsImportedAsAliasProcessor implements InlineFqnProcessor
{
    use CreateInlineFqnBasedOnImportedFqnTrait;

    public function shouldProcess(Node $parent, Name $name, ObjectDependencies $objectDependencies): bool
    {
        return $objectDependencies->getImportedFqnHavingAlias($name->parts[0]) !== null;
    }

    public function process(Node $parent, Name $name, ObjectDependencies $objectDependencies): ?Fqn
    {
        $importedFqn = $objectDependencies->getImportedFqnHavingAlias($name->parts[0]);

        if ($importedFqn === null) {
            return null;
        }

        return $this->createInlineFqnBasedOnImportedFqn($importedFqn, $name);
    }
}
