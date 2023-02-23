<?php

declare(strict_types=1);

namespace Jerowork\ClassDependenciesParser\PhpParser\NodeVisitor\InlineFqnParser\Processor;

use Jerowork\ClassDependenciesParser\Fqn;
use Jerowork\ClassDependenciesParser\ClassDependencies;
use PhpParser\Node;
use PhpParser\Node\Name;

interface InlineFqnProcessor
{
    public function shouldProcess(Node $parent, Name $name, ClassDependencies $classDependencies): bool;

    public function process(Node $parent, Name $name, ClassDependencies $classDependencies): ?Fqn;
}
