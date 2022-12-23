<?php

declare(strict_types=1);

namespace Jerowork\ObjectDependenciesParser\Test\PhpParser\Stub;

use DateTimeZone;
use Jerowork\ObjectDependenciesParser\Test\PhpParser\Stub\Constants\ConstantInterface;
use Jerowork\ObjectDependenciesParser\Test\PhpParser\Stub\Service\SomeService as AliasedService;
use Jerowork\ObjectDependenciesParser\Test\PhpParser\Stub\Trait as AliasedTraitFolder;
use Jerowork\ObjectDependenciesParser\Test\PhpParser\Stub\Trait\SomeTrait;
use Jerowork\ObjectDependenciesParser\Test\PhpParser\Stub\Dto\{
    SomeDto,
    AnotherDto,
};
use Jerowork\ObjectDependenciesParser\Test\PhpParser\Stub\Interface\SomeInterface;
use DateTimeImmutable;
use DateTime;
use function Jerowork\ObjectDependenciesParser\Test\PhpParser\Stub\Function\aliasedFunction as functionAliased;
use function Jerowork\ObjectDependenciesParser\Test\PhpParser\Stub\Function\someFunction;

#[\Attribute]
/**
 * @internal
 */
final class ClassStub extends AbstractClass implements \Jerowork\ObjectDependenciesParser\Test\PhpParser\Stub\Interface\AnotherInterface, RootLevelInterface
{
    use TraitStub;
    use AliasedTraitFolder\AnotherTrait;
    use SomeTrait;

    private const TEST = 'test';

    private \Jerowork\ObjectDependenciesParser\Test\PhpParser\Stub\Service\AnotherService $service;

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
    #[\Jerowork\ObjectDependenciesParser\Test\PhpParser\Stub\Attribute\AnotherAttribute]
    public function some(SomeDto $someDto, AnotherDto $anotherDto): DateTime
    {
        $date = new DateTimeImmutable();
        $zone = new DateTimeZone('Europe/Amsterdam');

        $function = someFunction();
        $anotherFunction = \Jerowork\ObjectDependenciesParser\Test\PhpParser\Stub\Function\anotherFunction();

        rootFunction();
        functionAliased();

        // PHP native functions
        print_r([\str_replace('t', 'e', 'test')]);

        echo sprintf('hello world %s', 'S');

        $object = static::staticFunction();
        $object = self::staticFunction();

        // Constants
        $constant = ConstantInterface::SOME_CONSTANT;

        self::TEST;

        return new DateTime();
    }

    public static function staticFunction(): self
    {
        return new self();
    }
}
