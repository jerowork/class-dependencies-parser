<?php

declare(strict_types=1);

namespace Jerowork\ClassDependenciesParser\Test\PhpParser;

use Attribute;
use DateTime;
use DateTimeImmutable;
use DateTimeZone;
use Jerowork\ClassDependenciesParser\PhpParser\NodeTraverserFactory;
use Jerowork\ClassDependenciesParser\PhpParser\PhpParserClassDependenciesParser;
use Jerowork\ClassDependenciesParser\Test\PhpParser\Stub\AbstractClass;
use Jerowork\ClassDependenciesParser\Test\PhpParser\Stub\Attribute\AnotherAttribute;
use Jerowork\ClassDependenciesParser\Test\PhpParser\Stub\Attribute\SomeAttribute;
use Jerowork\ClassDependenciesParser\Test\PhpParser\Stub\Constants\ConstantInterface;
use Jerowork\ClassDependenciesParser\Test\PhpParser\Stub\Dto\AnotherDto;
use Jerowork\ClassDependenciesParser\Test\PhpParser\Stub\Dto\SomeDto;
use Jerowork\ClassDependenciesParser\Test\PhpParser\Stub\Interface\AnotherInterface;
use Jerowork\ClassDependenciesParser\Test\PhpParser\Stub\Interface\SomeInterface;
use Jerowork\ClassDependenciesParser\Test\PhpParser\Stub\InterfaceStub;
use Jerowork\ClassDependenciesParser\Test\PhpParser\Stub\RootLevelAttribute;
use Jerowork\ClassDependenciesParser\Test\PhpParser\Stub\RootLevelDto;
use Jerowork\ClassDependenciesParser\Test\PhpParser\Stub\RootLevelEnum;
use Jerowork\ClassDependenciesParser\Test\PhpParser\Stub\RootLevelInterface;
use Jerowork\ClassDependenciesParser\Test\PhpParser\Stub\RootLevelService;
use Jerowork\ClassDependenciesParser\Test\PhpParser\Stub\Service\AnotherService;
use Jerowork\ClassDependenciesParser\Test\PhpParser\Stub\Service\SomeService;
use Jerowork\ClassDependenciesParser\Test\PhpParser\Stub\Trait\AnotherTrait;
use Jerowork\ClassDependenciesParser\Test\PhpParser\Stub\Trait\SomeTrait;
use Jerowork\ClassDependenciesParser\Test\PhpParser\Stub\TraitStub;
use PhpParser\ParserFactory;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class PhpParserClassDependenciesParserTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldGetParseDependenciesForClass(): void
    {
        $class = __DIR__ . '/Stub/ClassStub.php';

        $parser = new PhpParserClassDependenciesParser(
            (new ParserFactory())->create(ParserFactory::PREFER_PHP7),
            new NodeTraverserFactory(),
        );

        $classDependencies = $parser->parse($class);

        self::assertSame([
            Attribute::class,
            DateTime::class,
            DateTimeImmutable::class,
            DateTimeZone::class,
            AbstractClass::class,
            AnotherAttribute::class,
            SomeAttribute::class,
            ConstantInterface::class,
            AnotherDto::class,
            SomeDto::class,
            'Jerowork\ClassDependenciesParser\Test\PhpParser\Stub\Function\aliasedFunction',
            'Jerowork\ClassDependenciesParser\Test\PhpParser\Stub\Function\anotherFunction',
            'Jerowork\ClassDependenciesParser\Test\PhpParser\Stub\Function\someFunction',
            AnotherInterface::class,
            SomeInterface::class,
            RootLevelAttribute::class,
            RootLevelDto::class,
            RootLevelEnum::class,
            RootLevelInterface::class,
            RootLevelService::class,
            AnotherService::class,
            SomeService::class,
            TraitStub::class,
            AnotherTrait::class,
            SomeTrait::class,
            'Jerowork\ClassDependenciesParser\Test\PhpParser\Stub\rootFunction',
            'print_r',
            'sprintf',
            'str_replace',
        ], $classDependencies->getDependencyList());
    }

    /**
     * @test
     */
    public function itShouldGetParseDependenciesForTrait(): void
    {
        $class = __DIR__ . '/Stub/TraitStub.php';

        $parser = new PhpParserClassDependenciesParser(
            (new ParserFactory())->create(ParserFactory::PREFER_PHP7),
            new NodeTraverserFactory(),
        );

        $classDependencies = $parser->parse($class);

        self::assertSame([
            AnotherAttribute::class,
            AnotherDto::class,
            SomeDto::class,
            AnotherTrait::class,
            SomeTrait::class,
        ], $classDependencies->getDependencyList());
    }

    /**
     * @test
     */
    public function itShouldGetParseDependenciesForInterface(): void
    {
        $class = __DIR__ . '/Stub/InterfaceStub.php';

        $parser = new PhpParserClassDependenciesParser(
            (new ParserFactory())->create(ParserFactory::PREFER_PHP7),
            new NodeTraverserFactory(),
        );

        $classDependencies = $parser->parse($class);

        self::assertSame([
            DateTimeZone::class,
            AnotherInterface::class,
            SomeInterface::class,
            RootLevelAttribute::class,
            SomeService::class,
        ], $classDependencies->getDependencyList());
    }

    /**
     * @test
     */
    public function itShouldGetParseDependenciesForEnum(): void
    {
        $class = __DIR__ . '/Stub/RootLevelEnum.php';

        $parser = new PhpParserClassDependenciesParser(
            (new ParserFactory())->create(ParserFactory::PREFER_PHP7),
            new NodeTraverserFactory(),
        );

        $classDependencies = $parser->parse($class);

        self::assertSame([
            DateTimeZone::class,
            InterfaceStub::class,
            RootLevelAttribute::class,
            SomeService::class,
        ], $classDependencies->getDependencyList());
    }
}
