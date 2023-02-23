<?php

declare(strict_types=1);

namespace Jerowork\ClassDependenciesParser\PhpParser;

use Jerowork\ClassDependenciesParser\ClassDependencies;
use Jerowork\ClassDependenciesParser\PhpParser\NodeVisitor\InlineFqnParser\Decliner\ImportedFqnDecliner;
use Jerowork\ClassDependenciesParser\PhpParser\NodeVisitor\InlineFqnParser\Decliner\NamespaceDecliner;
use Jerowork\ClassDependenciesParser\PhpParser\NodeVisitor\InlineFqnParser\Decliner\PhpNativeAccessorDecliner;
use Jerowork\ClassDependenciesParser\PhpParser\NodeVisitor\InlineFqnParser\Processor\FullyQualifiedNameProcessor;
use Jerowork\ClassDependenciesParser\PhpParser\NodeVisitor\InlineFqnParser\Processor\InlineFqnIsImportedAsAliasProcessor;
use Jerowork\ClassDependenciesParser\PhpParser\NodeVisitor\InlineFqnParser\Processor\InlineFqnIsImportedProcessor;
use Jerowork\ClassDependenciesParser\PhpParser\NodeVisitor\InlineFqnParser\Processor\InlineFqnWithinSameNamespaceProcessor;
use Jerowork\ClassDependenciesParser\PhpParser\NodeVisitor\InlineFqnParser\Processor\RootLevelFunctionProcessor;
use Jerowork\ClassDependenciesParser\PhpParser\NodeVisitor\ParseImportedFqnNodeVisitor;
use Jerowork\ClassDependenciesParser\PhpParser\NodeVisitor\ParseInlineFqnNodeVisitor;
use Jerowork\ClassDependenciesParser\PhpParser\NodeVisitor\ParseClassFqnNodeVisitor;
use PhpParser\NodeTraverser;
use PhpParser\NodeTraverserInterface;
use PhpParser\NodeVisitor\ParentConnectingVisitor;

final class NodeTraverserFactory
{
    public function createTraverser(ClassDependencies $classDependencies): NodeTraverserInterface
    {
        $traverser = new NodeTraverser();

        $traverser->addVisitor(new ParentConnectingVisitor());
        $traverser->addVisitor(new ParseClassFqnNodeVisitor($classDependencies));
        $traverser->addVisitor(new ParseImportedFqnNodeVisitor($classDependencies));
        $traverser->addVisitor(new ParseInlineFqnNodeVisitor(
            $classDependencies,
            [
                new NamespaceDecliner(),
                new ImportedFqnDecliner(),
                new PhpNativeAccessorDecliner(),
            ],
            [
                new FullyQualifiedNameProcessor(),
                new RootLevelFunctionProcessor(),
                new InlineFqnIsImportedProcessor(),
                new InlineFqnIsImportedAsAliasProcessor(),
                new InlineFqnWithinSameNamespaceProcessor(),
            ],
        ));

        return $traverser;
    }
}
