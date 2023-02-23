<?php

declare(strict_types=1);

namespace Jerowork\ClassDependenciesParser\PhpParser\NodeVisitor\InlineFqnParser\Processor;

use Jerowork\ClassDependenciesParser\Fqn;
use Jerowork\ClassDependenciesParser\ClassDependencies;
use PhpParser\Node;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Name;

/**
 * All non Fully-qualified Name statements with one name part and exists as function.
 */
final class RootLevelFunctionProcessor implements InlineFqnProcessor
{
    public function shouldProcess(Node $parent, Name $name, ClassDependencies $classDependencies): bool
    {
        return $parent instanceof FuncCall && count($name->parts) === 1 && function_exists((string) $name);
    }

    public function process(Node $parent, Name $name, ClassDependencies $classDependencies): ?Fqn
    {
        return new Fqn((string) $name);
    }
}
