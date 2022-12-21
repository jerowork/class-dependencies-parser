<?php

declare(strict_types=1);

namespace Jerowork\ObjectDependenciesParser\Test;

use Jerowork\ObjectDependenciesParser\Fqn;
use Jerowork\ObjectDependenciesParser\ImportedFqn;
use Jerowork\ObjectDependenciesParser\ObjectDependencies;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class ObjectDependenciesTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldSetFqn(): void
    {
        $objectDependencies = new ObjectDependencies('/Path/To/Object.php');
        $objectDependencies->setFqn($fqn = new Fqn(ObjectDependenciesTest::class));

        self::assertSame($fqn, $objectDependencies->getFqn());
    }

    /**
     * @test
     */
    public function itShouldAddImportFqn(): void
    {
        $objectDependencies = new ObjectDependencies('/Path/To/Object.php');

        self::assertSame([], $objectDependencies->getImportedFqn());

        $objectDependencies->addImportedFqn(
            $importedFqn1 = new ImportedFqn(new Fqn(ObjectDependenciesTest::class), true, null),
        );
        $objectDependencies->addImportedFqn(
            $importedFqn2 = new ImportedFqn(new Fqn(ImportedFqnTest::class), true, 'alias'),
        );

        self::assertSame([
            ObjectDependenciesTest::class => $importedFqn1,
            ImportedFqnTest::class => $importedFqn2,
        ], $objectDependencies->getImportedFqn());
    }

    /**
     * @test
     */
    public function itShouldAddInlineFqn(): void
    {
        $objectDependencies = new ObjectDependencies('/Path/To/Object.php');

        self::assertSame([], $objectDependencies->getInlineFqn());

        $objectDependencies->addInlineFqn(
            $inlineFqn1 = new Fqn(ObjectDependenciesTest::class),
        );
        $objectDependencies->addInlineFqn(
            $inlineFqn2 = new Fqn(ImportedFqnTest::class),
        );

        self::assertSame([
            ObjectDependenciesTest::class => $inlineFqn1,
            ImportedFqnTest::class => $inlineFqn2,
        ], $objectDependencies->getInlineFqn());
    }

    /**
     * @test
     */
    public function itShouldVerifyIfFqnIsImported(): void
    {
        $objectDependencies = new ObjectDependencies('/Path/To/Object.php');

        $objectDependencies->addImportedFqn(
            new ImportedFqn(new Fqn(ObjectDependenciesTest::class), true, null),
        );

        self::assertTrue($objectDependencies->hasImportedFqn(new Fqn(ObjectDependenciesTest::class)));
        self::assertFalse($objectDependencies->hasImportedFqn(new Fqn(ImportedFqnTest::class)));
    }

    /**
     * @test
     */
    public function itShouldGetImportedFqnWithLastPart(): void
    {
        $objectDependencies = new ObjectDependencies('/Path/To/Object.php');

        $objectDependencies->addImportedFqn(
            $importedFqn = new ImportedFqn(new Fqn(ObjectDependenciesTest::class), true, null),
        );

        self::assertSame($importedFqn, $objectDependencies->getImportedFqnHavingLastPart('ObjectDependenciesTest'));
        self::assertNull($objectDependencies->getImportedFqnHavingLastPart('ImportedFqnTest'));
    }

    /**
     * @test
     */
    public function itShouldGetImportedFqnWithAlias(): void
    {
        $objectDependencies = new ObjectDependencies('/Path/To/Object.php');

        $objectDependencies->addImportedFqn(
            $importedFqn = new ImportedFqn(new Fqn(ObjectDependenciesTest::class), true, 'SomeAlias'),
        );

        self::assertSame($importedFqn, $objectDependencies->getImportedFqnHavingAlias('SomeAlias'));
        self::assertNull($objectDependencies->getImportedFqnHavingAlias('AnotherAlias'));
    }

    /**
     * @test
     */
    public function itShouldGetAllDependenciesAsList(): void
    {
        $objectDependencies = new ObjectDependencies('/Path/To/Object.php');

        self::assertSame([], $objectDependencies->getInlineFqn());

        $objectDependencies->addImportedFqn(
            new ImportedFqn(new Fqn(ObjectDependenciesTest::class), true, null),
        );
        $objectDependencies->addImportedFqn(
            new ImportedFqn(new Fqn(ImportedFqnTest::class), true, 'alias'),
        );

        $objectDependencies->addInlineFqn(new Fqn(ImportedFqn::class));
        $objectDependencies->addInlineFqn(new Fqn(Fqn::class));

        self::assertSame([
            Fqn::class,
            ImportedFqn::class,
            ImportedFqnTest::class,
            ObjectDependenciesTest::class,
        ], $objectDependencies->getDependencyList());
    }
}
