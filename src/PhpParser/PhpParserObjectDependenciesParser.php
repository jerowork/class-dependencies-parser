<?php

declare(strict_types=1);

namespace Jerowork\ObjectDependenciesParser\PhpParser;

use Jerowork\ObjectDependenciesParser\ObjectDependencies;
use Jerowork\ObjectDependenciesParser\ObjectDependenciesParser;
use PhpParser\Parser;

final class PhpParserObjectDependenciesParser implements ObjectDependenciesParser
{
    public function __construct(
        private readonly Parser $parser,
        private readonly NodeTraverserFactory $traverserFactory,
    ) {
    }

    public function parse(string $filePath): ObjectDependencies
    {
        $objectDependencies = new ObjectDependencies($filePath);

        $fileAst = $this->parser->parse((string) file_get_contents($filePath));

        if ($fileAst === null) {
            return $objectDependencies;
        }

        $traverser = $this->traverserFactory->createTraverser($objectDependencies);
        $traverser->traverse($fileAst);

        return $objectDependencies;
    }
}
