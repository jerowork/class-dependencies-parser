<?php

declare(strict_types=1);

namespace Jerowork\ObjectDependenciesParser\PhpParser\NodeVisitor;

final class PhpNativeDefinitions
{
    public const FUNCTIONS = [
        'print_r',
        'str_replace',
        'sprintf',
    ];

    public const ACCESSORS = [
        'self',
        'static',
        'parent',
    ];
}
