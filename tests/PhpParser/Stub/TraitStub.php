<?php

declare(strict_types=1);

namespace Jerowork\ClassDependenciesParser\Test\PhpParser\Stub;

use Jerowork\ClassDependenciesParser\Test\PhpParser\Stub\Dto\AnotherDto;
use Jerowork\ClassDependenciesParser\Test\PhpParser\Stub\Dto\SomeDto;
use Jerowork\ClassDependenciesParser\Test\PhpParser\Stub\Trait\AnotherTrait;
use Jerowork\ClassDependenciesParser\Test\PhpParser\Stub\Trait\SomeTrait;

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
