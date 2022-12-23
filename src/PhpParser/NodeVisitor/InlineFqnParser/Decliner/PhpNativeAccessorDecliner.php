<?php

declare(strict_types=1);

namespace Jerowork\ObjectDependenciesParser\PhpParser\NodeVisitor\InlineFqnParser\Decliner;

use Jerowork\ObjectDependenciesParser\ObjectDependencies;
use PhpParser\Node;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt\ClassMethod;

final class PhpNativeAccessorDecliner implements InlineFqnDecliner
{
    private const ACCESSORS = ['self', 'static', 'parent'];

    public function shouldDecline(Node $parent, Name $name, ObjectDependencies $objectDependencies): bool
    {
        // Ignore PHP native accessors
        return ($parent instanceof New_ || $parent instanceof StaticCall || $parent instanceof ClassMethod)
            && in_array((string) $name, self::ACCESSORS, true);
    }
}
