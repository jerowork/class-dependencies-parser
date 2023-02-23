<?php

declare(strict_types=1);

namespace Jerowork\ClassDependenciesParser\Test\PhpParser\Stub;

use Jerowork\ClassDependenciesParser\Test\PhpParser\Stub\Interface\SomeInterface;
use Jerowork\ClassDependenciesParser\Test\PhpParser\Stub\Service\SomeService;
use DateTimeZone;

interface InterfaceStub extends SomeInterface, \Jerowork\ClassDependenciesParser\Test\PhpParser\Stub\Interface\AnotherInterface
{
    #[RootLevelAttribute]
    public function some(SomeService $service): DateTimeZone;
}
