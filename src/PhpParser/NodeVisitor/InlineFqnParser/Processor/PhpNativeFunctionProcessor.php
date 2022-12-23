<?php

declare(strict_types=1);

namespace Jerowork\ObjectDependenciesParser\PhpParser\NodeVisitor\InlineFqnParser\Processor;

use Jerowork\ObjectDependenciesParser\Fqn;
use Jerowork\ObjectDependenciesParser\ObjectDependencies;
use PhpParser\Node;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Name;

final class PhpNativeFunctionProcessor implements InlineFqnProcessor
{
    public function shouldProcess(Node $parent, Name $name, ObjectDependencies $objectDependencies): bool
    {
        return $parent instanceof FuncCall
            && in_array((string) $name, PhpNativeFunctionList::FUNCTIONS, true);
    }

    public function process(Node $parent, Name $name, ObjectDependencies $objectDependencies): ?Fqn
    {
        return new Fqn((string) $name);
    }
}
