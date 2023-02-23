<?php

declare(strict_types=1);

namespace Jerowork\ClassDependenciesParser\PhpParser\NodeVisitor\InlineFqnParser\Processor;

use Jerowork\ClassDependenciesParser\Fqn;
use Jerowork\ClassDependenciesParser\ClassDependencies;
use PhpParser\Node;
use PhpParser\Node\Name;

final class InlineFqnWithinSameNamespaceProcessor implements InlineFqnProcessor
{
    public function shouldProcess(Node $parent, Name $name, ClassDependencies $classDependencies): bool
    {
        // Fallback processor, needs to be processed as last
        return true;
    }

    public function process(Node $parent, Name $name, ClassDependencies $classDependencies): ?Fqn
    {
        $classFqn = $classDependencies->getFqn();

        if ($classFqn === null) {
            return null;
        }

        return new Fqn(sprintf('%s\%s', $classFqn->getFullFqnWithoutLastPart(), $name));
    }
}
