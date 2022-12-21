<?php

declare(strict_types=1);

namespace Jerowork\ObjectDependenciesParser\PhpParser;

use Jerowork\ObjectDependenciesParser\ObjectDependencies;
use Jerowork\ObjectDependenciesParser\PhpParser\NodeVisitor\ParseImportedFqnNodeVisitor;
use Jerowork\ObjectDependenciesParser\PhpParser\NodeVisitor\ParseInlineFqnNodeVisitor;
use Jerowork\ObjectDependenciesParser\PhpParser\NodeVisitor\ParseObjectFqnNodeVisitor;
use PhpParser\NodeTraverser;
use PhpParser\NodeTraverserInterface;
use PhpParser\NodeVisitor\ParentConnectingVisitor;

final class NodeTraverserFactory
{
    public function createTraverser(ObjectDependencies $objectDependencies): NodeTraverserInterface
    {
        $traverser = new NodeTraverser();

        $traverser->addVisitor(new ParentConnectingVisitor());
        $traverser->addVisitor(new ParseObjectFqnNodeVisitor($objectDependencies));
        $traverser->addVisitor(new ParseImportedFqnNodeVisitor($objectDependencies));
        $traverser->addVisitor(new ParseInlineFqnNodeVisitor($objectDependencies));

        return $traverser;
    }
}
