<?php

declare(strict_types=1);

namespace Jerowork\ObjectDependenciesParser\PhpParser\NodeVisitor\InlineFqnParser\Processor;

use Jerowork\ObjectDependenciesParser\Fqn;
use Jerowork\ObjectDependenciesParser\ObjectDependencies;
use PhpParser\Node;
use PhpParser\Node\Name;

interface InlineFqnProcessor
{
    public function shouldProcess(Node $parent, Name $name, ObjectDependencies $objectDependencies): bool;

    public function process(Node $parent, Name $name, ObjectDependencies $objectDependencies): ?Fqn;
}
