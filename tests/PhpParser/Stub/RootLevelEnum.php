<?php

declare(strict_types=1);

namespace Jerowork\ClassDependenciesParser\Test\PhpParser\Stub;

use DateTimeZone;
use Jerowork\ClassDependenciesParser\Test\PhpParser\Stub\Service\SomeService;

enum RootLevelEnum : string implements InterfaceStub
{
    case Amsterdam = 'Europe/Amsterdam';

    #[RootLevelAttribute] public function some(SomeService $service): DateTimeZone
    {
        return new DateTimeZone(self::Amsterdam->value);
    }
}
