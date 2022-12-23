<?php

declare(strict_types=1);

namespace Jerowork\ObjectDependenciesParser\PhpParser\NodeVisitor\InlineFqnParser\Processor;

use Jerowork\ObjectDependenciesParser\Fqn;
use Jerowork\ObjectDependenciesParser\ObjectDependencies;
use PhpParser\Node;
use PhpParser\Node\Name;
use PhpParser\Node\Name\FullyQualified;

final class FullyQualifiedNameProcessor implements InlineFqnProcessor
{
    public function shouldProcess(Node $parent, Name $name, ObjectDependencies $objectDependencies): bool
    {
        return $name instanceof FullyQualified;
    }

    public function process(Node $parent, Name $name, ObjectDependencies $objectDependencies): ?Fqn
    {
        // FQN is already imported (use statement)
        if ($objectDependencies->hasImportedFqn(Fqn::createFromParts($name->parts))) {
            return null;
        }

        return Fqn::createFromParts($name->parts);
    }
}
