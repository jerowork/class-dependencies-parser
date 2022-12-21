<?php

declare(strict_types=1);

namespace Jerowork\ObjectDependenciesParser\Test;

use Jerowork\ObjectDependenciesParser\Fqn;
use Jerowork\ObjectDependenciesParser\ImportedFqn;
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
        self::assertTrue($importedFqn->isObject);
        self::assertSame('alias', $importedFqn->alias);
    }

    /**
     * @test
     */
    public function itShouldSetImportedFqnAsNonObject(): void
    {
        $importedFqn = new ImportedFqn(
            new Fqn(ImportedFqnTest::class),
            true,
            'alias',
        );

        self::assertTrue($importedFqn->isObject);

        $importedFqn->isNotObject();

        self::assertFalse($importedFqn->isObject);
    }
}
