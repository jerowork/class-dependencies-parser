<?php

declare(strict_types=1);

namespace Jerowork\ObjectDependenciesParser\PhpParser\NodeVisitor\InlineFqnParser\Processor;

use Jerowork\ObjectDependenciesParser\Fqn;
use Jerowork\ObjectDependenciesParser\ObjectDependencies;
use PhpParser\Node;
use PhpParser\Node\Name;

final class InlineFqnWithinSameNamespaceProcessor implements InlineFqnProcessor
{
    public function shouldProcess(Node $parent, Name $name, ObjectDependencies $objectDependencies): bool
    {
        // Fallback processor, needs to be processed as last
        return true;
    }

    public function process(Node $parent, Name $name, ObjectDependencies $objectDependencies): ?Fqn
    {
        $objectFqn = $objectDependencies->getFqn();

        if ($objectFqn === null) {
            return null;
        }

        return new Fqn(sprintf('%s\%s', $objectFqn->getFullFqnWithoutLastPart(), $name));
    }
}
