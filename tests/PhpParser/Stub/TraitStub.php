<?php

declare(strict_types=1);

namespace Jerowork\ObjectDependenciesParser\Test\PhpParser\Stub;

use Jerowork\ObjectDependenciesParser\Test\PhpParser\Stub\Dto\AnotherDto;
use Jerowork\ObjectDependenciesParser\Test\PhpParser\Stub\Dto\SomeDto;
use Jerowork\ObjectDependenciesParser\Test\PhpParser\Stub\Trait\AnotherTrait;
use Jerowork\ObjectDependenciesParser\Test\PhpParser\Stub\Trait\SomeTrait;

trait TraitStub
{
    use AnotherTrait;
    use SomeTrait;

    #[Attribute\AnotherAttribute]
    public function some(AnotherDto $anotherDto): void
    {
        $some = new SomeDto();
    }
}
