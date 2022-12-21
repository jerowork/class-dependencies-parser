<?php

declare(strict_types=1);

namespace Jerowork\ObjectDependenciesParser;

interface ObjectDependenciesParser
{
    public function parse(string $filePath): ObjectDependencies;
}
