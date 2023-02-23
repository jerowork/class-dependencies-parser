<?php

declare(strict_types=1);

namespace Jerowork\ClassDependenciesParser\PhpParser;

use Jerowork\ClassDependenciesParser\ClassDependencies;
use Jerowork\ClassDependenciesParser\ClassDependenciesParser;
use PhpParser\Parser;

final class PhpParserClassDependenciesParser implements ClassDependenciesParser
{
    public function __construct(
        private readonly Parser $parser,
        private readonly NodeTraverserFactory $traverserFactory,
    ) {
    }

    public function parse(string $filePath): ClassDependencies
    {
        $classDependencies = new ClassDependencies($filePath);

        $fileAst = $this->parser->parse((string) file_get_contents($filePath));

        if ($fileAst === null) {
            return $classDependencies;
        }

        $traverser = $this->traverserFactory->createTraverser($classDependencies);
        $traverser->traverse($fileAst);

        return $classDependencies;
    }
}
