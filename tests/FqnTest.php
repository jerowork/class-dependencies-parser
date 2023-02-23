<?php

declare(strict_types=1);

namespace Jerowork\ClassDependenciesParser\Test;

use Jerowork\ClassDependenciesParser\Fqn;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class FqnTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldCreate(): void
    {
        $fqn = new Fqn(FqnTest::class);

        self::assertSame(FqnTest::class, (string) $fqn);
    }

    /**
     * @test
     */
    public function itShouldCreateFromParts(): void
    {
        $fqn = Fqn::createFromParts(['Jerowork', 'ClassDependenciesParser', 'Test', 'FqnTest']);

        self::assertSame(FqnTest::class, (string) $fqn);
    }

    /**
     * @test
     */
    public function itShouldGetParts(): void
    {
        $fqn = new Fqn(FqnTest::class);

        self::assertSame(['Jerowork', 'ClassDependenciesParser', 'Test', 'FqnTest'], $fqn->getParts());
    }

    /**
     * @test
     */
    public function itShouldGetFullFqnWithoutLastPart(): void
    {
        $fqn = new Fqn(FqnTest::class);

        self::assertSame('Jerowork\ClassDependenciesParser\Test', $fqn->getFullFqnWithoutLastPart());
    }

    /**
     * @test
     */
    public function itShouldGetLastPart(): void
    {
        $fqn = new Fqn(FqnTest::class);

        self::assertSame('FqnTest', $fqn->getLastPart());
    }

    /**
     * @test
     */
    public function itShouldEqual(): void
    {
        $fqn = new Fqn(FqnTest::class);

        self::assertTrue($fqn->equals(Fqn::createFromParts(['Jerowork', 'ClassDependenciesParser', 'Test', 'FqnTest'])));
        self::assertFalse($fqn->equals(Fqn::createFromParts(['Other', 'Class'])));
    }
}
