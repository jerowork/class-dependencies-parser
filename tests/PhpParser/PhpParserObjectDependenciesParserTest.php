<?php

declare(strict_types=1);

namespace Jerowork\ObjectDependenciesParser\Test\PhpParser;

use Attribute;
use DateTime;
use DateTimeImmutable;
use DateTimeZone;
use Jerowork\ObjectDependenciesParser\PhpParser\NodeTraverserFactory;
use Jerowork\ObjectDependenciesParser\PhpParser\PhpParserObjectDependenciesParser;
use Jerowork\ObjectDependenciesParser\Test\PhpParser\Stub\AbstractClass;
use Jerowork\ObjectDependenciesParser\Test\PhpParser\Stub\Attribute\AnotherAttribute;
use Jerowork\ObjectDependenciesParser\Test\PhpParser\Stub\Attribute\SomeAttribute;
use Jerowork\ObjectDependenciesParser\Test\PhpParser\Stub\Dto\AnotherDto;
use Jerowork\ObjectDependenciesParser\Test\PhpParser\Stub\Dto\SomeDto;
use Jerowork\ObjectDependenciesParser\Test\PhpParser\Stub\Interface\AnotherInterface;
use Jerowork\ObjectDependenciesParser\Test\PhpParser\Stub\Interface\SomeInterface;
use Jerowork\ObjectDependenciesParser\Test\PhpParser\Stub\RootLevelAttribute;
use Jerowork\ObjectDependenciesParser\Test\PhpParser\Stub\RootLevelDto;
use Jerowork\ObjectDependenciesParser\Test\PhpParser\Stub\RootLevelInterface;
use Jerowork\ObjectDependenciesParser\Test\PhpParser\Stub\RootLevelService;
use Jerowork\ObjectDependenciesParser\Test\PhpParser\Stub\Service\AnotherService;
use Jerowork\ObjectDependenciesParser\Test\PhpParser\Stub\Service\SomeService;
use Jerowork\ObjectDependenciesParser\Test\PhpParser\Stub\Trait\AnotherTrait;
use Jerowork\ObjectDependenciesParser\Test\PhpParser\Stub\Trait\SomeTrait;
use Jerowork\ObjectDependenciesParser\Test\PhpParser\Stub\TraitStub;
use PhpParser\ParserFactory;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class PhpParserObjectDependenciesParserTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldGetParseDependenciesForClass(): void
    {
        $class = __DIR__ . '/Stub/ClassStub.php';

        $parser = new PhpParserObjectDependenciesParser(
            (new ParserFactory())->create(ParserFactory::PREFER_PHP7),
            new NodeTraverserFactory(),
        );

        $objectDependencies = $parser->parse($class);

        self::assertSame([
            Attribute::class,
            DateTime::class,
            DateTimeImmutable::class,
            DateTimeZone::class,
            AbstractClass::class,
            AnotherAttribute::class,
            SomeAttribute::class,
            AnotherDto::class,
            SomeDto::class,
            'Jerowork\ObjectDependenciesParser\Test\PhpParser\Stub\Function\aliasedFunction',
            'Jerowork\ObjectDependenciesParser\Test\PhpParser\Stub\Function\anotherFunction',
            'Jerowork\ObjectDependenciesParser\Test\PhpParser\Stub\Function\someFunction',
            AnotherInterface::class,
            SomeInterface::class,
            RootLevelAttribute::class,
            RootLevelDto::class,
            RootLevelInterface::class,
            RootLevelService::class,
            AnotherService::class,
            SomeService::class,
            TraitStub::class,
            AnotherTrait::class,
            SomeTrait::class,
            'Jerowork\ObjectDependenciesParser\Test\PhpParser\Stub\rootFunction',
            'print_r',
            'sprintf',
            'str_replace',
        ], $objectDependencies->getDependencyList());
    }

    /**
     * @test
     */
    public function itShouldGetParseDependenciesForTrait(): void
    {
        $class = __DIR__ . '/Stub/TraitStub.php';

        $parser = new PhpParserObjectDependenciesParser(
            (new ParserFactory())->create(ParserFactory::PREFER_PHP7),
            new NodeTraverserFactory(),
        );

        $objectDependencies = $parser->parse($class);

        self::assertSame([
            AnotherAttribute::class,
            AnotherDto::class,
            SomeDto::class,
            AnotherTrait::class,
            SomeTrait::class,
        ], $objectDependencies->getDependencyList());
    }

    /**
     * @test
     */
    public function itShouldGetParseDependenciesForInterface(): void
    {
        $class = __DIR__ . '/Stub/InterfaceStub.php';

        $parser = new PhpParserObjectDependenciesParser(
            (new ParserFactory())->create(ParserFactory::PREFER_PHP7),
            new NodeTraverserFactory(),
        );

        $objectDependencies = $parser->parse($class);

        self::assertSame([
            DateTimeZone::class,
            AnotherInterface::class,
            SomeInterface::class,
            RootLevelAttribute::class,
            SomeService::class,
        ], $objectDependencies->getDependencyList());
    }
}
