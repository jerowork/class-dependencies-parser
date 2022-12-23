<?php

declare(strict_types=1);

namespace Jerowork\ObjectDependenciesParser\PhpParser\NodeVisitor\InlineFqnParser\Processor;

final class PhpNativeFunctionList
{
    public const FUNCTIONS = [
        'print_r',
        'str_replace',
        'sprintf',
    ];
}
