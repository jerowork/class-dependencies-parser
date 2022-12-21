<?php

declare(strict_types=1);

namespace Jerowork\ObjectDependenciesParser\Test\PhpParser\Stub;

use Jerowork\ObjectDependenciesParser\Test\PhpParser\Stub\Interface\SomeInterface;
use Jerowork\ObjectDependenciesParser\Test\PhpParser\Stub\Service\SomeService;
use DateTimeZone;

interface InterfaceStub extends SomeInterface, \Jerowork\ObjectDependenciesParser\Test\PhpParser\Stub\Interface\AnotherInterface
{
    #[RootLevelAttribute]
    public function some(SomeService $service): DateTimeZone;
}
