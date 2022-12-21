<?php

declare(strict_types=1);

namespace Jerowork\ObjectDependenciesParser\Test\PhpParser\Stub\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_ALL)]
final class SomeAttribute
{
    public function __construct(string $fqcn)
    {
    }
}
