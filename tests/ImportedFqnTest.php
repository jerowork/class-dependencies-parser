<?php

declare(strict_types=1);

namespace Jerowork\ClassDependenciesParser\Test;

use Jerowork\ClassDependenciesParser\Fqn;
use Jerowork\ClassDependenciesParser\ImportedFqn;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class ImportedFqnTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldConstruct(): void
    {
        $importedFqn = new ImportedFqn(
            $fqn = new Fqn(ImportedFqnTest::class),
            true,
            'alias',
        );

        self::assertSame($fqn, $importedFqn->fqn);
        self::assertTrue($importedFqn->isClass);
        self::assertSame('alias', $importedFqn->alias);
    }

    /**
     * @test
     */
    public function itShouldSetImportedFqnAsNonClass(): void
    {
        $importedFqn = new ImportedFqn(
            new Fqn(ImportedFqnTest::class),
            true,
            'alias',
        );

        self::assertTrue($importedFqn->isClass);

        $importedFqn->isNotClass();

        self::assertFalse($importedFqn->isClass);
    }
}
