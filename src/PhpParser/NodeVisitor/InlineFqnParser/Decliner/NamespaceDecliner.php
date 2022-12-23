<?php

declare(strict_types=1);

namespace Jerowork\ObjectDependenciesParser\PhpParser\NodeVisitor\InlineFqnParser\Decliner;

use Jerowork\ObjectDependenciesParser\ObjectDependencies;
use PhpParser\Node;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt\Namespace_;

/**
 * Decline namespace Name nodes.
 */
final class NamespaceDecliner implements InlineFqnDecliner
{
    public function shouldDecline(Node $parent, Name $name, ObjectDependencies $objectDependencies): bool
    {
        return $parent instanceof Namespace_;
    }
}
