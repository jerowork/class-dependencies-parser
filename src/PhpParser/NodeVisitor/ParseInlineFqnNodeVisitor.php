<?php

declare(strict_types=1);

namespace Jerowork\ObjectDependenciesParser\PhpParser\NodeVisitor;

use Jerowork\ObjectDependenciesParser\ObjectDependencies;
use Jerowork\ObjectDependenciesParser\PhpParser\NodeVisitor\InlineFqnParser\Decliner\InlineFqnDecliner;
use Jerowork\ObjectDependenciesParser\PhpParser\NodeVisitor\InlineFqnParser\Processor\InlineFqnProcessor;
use PhpParser\Node;
use PhpParser\Node\Name;
use PhpParser\NodeVisitorAbstract;

final class ParseInlineFqnNodeVisitor extends NodeVisitorAbstract
{
    /**
     * @param iterable<InlineFqnDecliner> $decliners
     * @param iterable<InlineFqnProcessor> $processors
     */
    public function __construct(
        private readonly ObjectDependencies $objectDependencies,
        private readonly iterable $decliners,
        private readonly iterable $processors,
    ) {
    }

    public function enterNode(Node $node): int|Node|null
    {
        if (!$node instanceof Name) {
            return parent::enterNode($node);
        }

        /** @var Node $parent */
        $parent = $node->getAttribute('parent');

        foreach ($this->decliners as $decliner) {
            if ($decliner->shouldDecline($parent, $node, $this->objectDependencies)) {
                return parent::enterNode($node);
            }
        }

        foreach ($this->processors as $processor) {
            if (!$processor->shouldProcess($parent, $node, $this->objectDependencies)) {
                continue;
            }

            $fqn = $processor->process($parent, $node, $this->objectDependencies);

            if ($fqn !== null) {
                $this->objectDependencies->addInlineFqn($fqn);
            }

            break;
        }

        return parent::enterNode($node);
    }
}
