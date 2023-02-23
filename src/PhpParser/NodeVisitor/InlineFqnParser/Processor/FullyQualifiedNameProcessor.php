<?php

declare(strict_types=1);

namespace Jerowork\ClassDependenciesParser\PhpParser\NodeVisitor\InlineFqnParser\Processor;

use Jerowork\ClassDependenciesParser\Fqn;
use Jerowork\ClassDependenciesParser\ClassDependencies;
use PhpParser\Node;
use PhpParser\Node\Name;
use PhpParser\Node\Name\FullyQualified;

final class FullyQualifiedNameProcessor implements InlineFqnProcessor
{
    public function shouldProcess(Node $parent, Name $name, ClassDependencies $classDependencies): bool
    {
        return $name instanceof FullyQualified;
    }

    public function process(Node $parent, Name $name, ClassDependencies $classDependencies): ?Fqn
    {
        // FQN is already imported (use statement)
        if ($classDependencies->hasImportedFqn(Fqn::createFromParts($name->parts))) {
            return null;
        }

        return Fqn::createFromParts($name->parts);
    }
}
