<?php

declare(strict_types=1);

namespace Jerowork\ClassDependenciesParser\PhpParser\NodeVisitor;

use Jerowork\ClassDependenciesParser\Fqn;
use Jerowork\ClassDependenciesParser\ClassDependencies;
use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\Enum_;
use PhpParser\Node\Stmt\Interface_;
use PhpParser\Node\Stmt\Namespace_;
use PhpParser\Node\Stmt\Trait_;
use PhpParser\NodeVisitorAbstract;

final class ParseClassFqnNodeVisitor extends NodeVisitorAbstract
{
    private ?string $namespace = null;
    private ?string $className = null;

    public function __construct(
        private readonly ClassDependencies $classDependencies,
    ) {
    }

    public function enterNode(Node $node): int|Node|null
    {
        if ($node instanceof Namespace_) {
            $this->namespace = (string) $node->name;
        }

        if ($node instanceof Class_ || $node instanceof Trait_ || $node instanceof Interface_ || $node instanceof Enum_) {
            $this->className = (string) $node->name;
        }

        if ($this->namespace !== null && $this->className !== null) {
            $this->classDependencies->setFqn(new Fqn(sprintf('%s\%s', $this->namespace, $this->className)));
        }

        return parent::enterNode($node);
    }
}
