<?php

declare(strict_types=1);

namespace Jerowork\ObjectDependenciesParser\PhpParser\NodeVisitor;

use Jerowork\ObjectDependenciesParser\Fqn;
use Jerowork\ObjectDependenciesParser\ObjectDependencies;
use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\Interface_;
use PhpParser\Node\Stmt\Namespace_;
use PhpParser\Node\Stmt\Trait_;
use PhpParser\NodeVisitorAbstract;

final class ParseObjectFqnNodeVisitor extends NodeVisitorAbstract
{
    private ?string $namespace = null;
    private ?string $objectName = null;

    public function __construct(
        private readonly ObjectDependencies $objectDependencies,
    ) {
    }

    public function enterNode(Node $node): int|Node|null
    {
        if ($node instanceof Namespace_) {
            $this->namespace = (string) $node->name;
        }

        if ($node instanceof Class_ || $node instanceof Trait_ || $node instanceof Interface_) {
            $this->objectName = (string) $node->name;
        }

        if ($this->namespace !== null && $this->objectName !== null) {
            $this->objectDependencies->setFqn(new Fqn(sprintf('%s\%s', $this->namespace, $this->objectName)));
        }

        return parent::enterNode($node);
    }
}
