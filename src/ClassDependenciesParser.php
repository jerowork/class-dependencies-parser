<?php

declare(strict_types=1);

namespace Jerowork\ClassDependenciesParser;

interface ClassDependenciesParser
{
    public function parse(string $filePath): ClassDependencies;
}
