<?php

declare(strict_types=1);

namespace Jerowork\ObjectDependenciesParser\PhpParser\NodeVisitor\InlineFqnParser\Decliner;

use Jerowork\ObjectDependenciesParser\ObjectDependencies;
use PhpParser\Node;
use PhpParser\Node\Name;

interface InlineFqnDecliner
{
    public function shouldDecline(Node $parent, Name $name, ObjectDependencies $objectDependencies): bool;
}
