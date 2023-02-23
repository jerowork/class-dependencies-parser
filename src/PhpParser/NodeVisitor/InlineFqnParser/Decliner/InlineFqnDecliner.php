<?php

declare(strict_types=1);

namespace Jerowork\ClassDependenciesParser\PhpParser\NodeVisitor\InlineFqnParser\Decliner;

use Jerowork\ClassDependenciesParser\ClassDependencies;
use PhpParser\Node;
use PhpParser\Node\Name;

interface InlineFqnDecliner
{
    public function shouldDecline(Node $parent, Name $name, ClassDependencies $classDependencies): bool;
}
