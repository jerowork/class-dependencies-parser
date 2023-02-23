<?php

declare(strict_types=1);

namespace Jerowork\ClassDependenciesParser\Test\PhpParser\Stub;

use DateTimeZone;
use Jerowork\ClassDependenciesParser\Test\PhpParser\Stub\Constants\ConstantInterface;
use Jerowork\ClassDependenciesParser\Test\PhpParser\Stub\Service\SomeService as AliasedService;
use Jerowork\ClassDependenciesParser\Test\PhpParser\Stub\Trait as AliasedTraitFolder;
use Jerowork\ClassDependenciesParser\Test\PhpParser\Stub\Trait\SomeTrait;
use Jerowork\ClassDependenciesParser\Test\PhpParser\Stub\Dto\{
    SomeDto,
    AnotherDto,
};
use Jerowork\ClassDependenciesParser\Test\PhpParser\Stub\Interface\SomeInterface;
use DateTimeImmutable;
use DateTime;
use function Jerowork\ClassDependenciesParser\Test\PhpParser\Stub\Function\aliasedFunction as functionAliased;
use function Jerowork\ClassDependenciesParser\Test\PhpParser\Stub\Function\someFunction;

#[\Attribute]
/**
 * @internal
 */
final class ClassStub extends AbstractClass implements \Jerowork\ClassDependenciesParser\Test\PhpParser\Stub\Interface\AnotherInterface, RootLevelInterface
{
    use TraitStub;
    use AliasedTraitFolder\AnotherTrait;
    use SomeTrait;

    private const TEST = 'test';

    private \Jerowork\ClassDependenciesParser\Test\PhpParser\Stub\Service\AnotherService $service;

    public function __construct(
        #[RootLevelAttribute]
        private readonly SomeInterface $some,
        private Interface\AnotherInterface $another,
        private RootLevelService $rootLevelService,
    ) {
        parent::__construct();

        $service = new AliasedService();
    }

    #[Attribute\SomeAttribute(RootLevelDto::class)]
    #[\Jerowork\ClassDependenciesParser\Test\PhpParser\Stub\Attribute\AnotherAttribute]
    public function some(SomeDto $someDto, AnotherDto $anotherDto): DateTime
    {
        $date = new DateTimeImmutable();
        $zone = new DateTimeZone('Europe/Amsterdam');

        $function = someFunction();
        $anotherFunction = \Jerowork\ClassDependenciesParser\Test\PhpParser\Stub\Function\anotherFunction();

        rootFunction();
        functionAliased();

        // PHP native functions
        print_r([\str_replace('t', 'e', 'test')]);

        echo sprintf('hello world %s', 'S');

        $class = static::staticFunction();
        $class = self::staticFunction();

        // Constants
        $constant = ConstantInterface::SOME_CONSTANT;

        self::TEST;

        // Enums
        $enum = RootLevelEnum::Amsterdam;

        return new DateTime();
    }

    public static function staticFunction(): self
    {
        return new self();
    }
}
