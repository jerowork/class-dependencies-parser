<?php

declare(strict_types=1);

namespace Jerowork\ClassDependenciesParser\Test;

use Jerowork\ClassDependenciesParser\Fqn;
use Jerowork\ClassDependenciesParser\ImportedFqn;
use Jerowork\ClassDependenciesParser\ClassDependencies;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class ClassDependenciesTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldSetFqn(): void
    {
        $classDependencies = new ClassDependencies('/Path/To/Class.php');
        $classDependencies->setFqn($fqn = new Fqn(ClassDependenciesTest::class));

        self::assertSame($fqn, $classDependencies->getFqn());
    }

    /**
     * @test
     */
    public function itShouldAddImportFqn(): void
    {
        $classDependencies = new ClassDependencies('/Path/To/Class.php');

        self::assertSame([], $classDependencies->getImportedFqn());

        $classDependencies->addImportedFqn(
            $importedFqn1 = new ImportedFqn(new Fqn(ClassDependenciesTest::class), true, null),
        );
        $classDependencies->addImportedFqn(
            $importedFqn2 = new ImportedFqn(new Fqn(ImportedFqnTest::class), true, 'alias'),
        );

        self::assertSame([
            ClassDependenciesTest::class => $importedFqn1,
            ImportedFqnTest::class => $importedFqn2,
        ], $classDependencies->getImportedFqn());
    }

    /**
     * @test
     */
    public function itShouldAddInlineFqn(): void
    {
        $classDependencies = new ClassDependencies('/Path/To/Class.php');

        self::assertSame([], $classDependencies->getInlineFqn());

        $classDependencies->addInlineFqn(
            $inlineFqn1 = new Fqn(ClassDependenciesTest::class),
        );
        $classDependencies->addInlineFqn(
            $inlineFqn2 = new Fqn(ImportedFqnTest::class),
        );

        self::assertSame([
            ClassDependenciesTest::class => $inlineFqn1,
            ImportedFqnTest::class => $inlineFqn2,
        ], $classDependencies->getInlineFqn());
    }

    /**
     * @test
     */
    public function itShouldVerifyIfFqnIsImported(): void
    {
        $classDependencies = new ClassDependencies('/Path/To/Class.php');

        $classDependencies->addImportedFqn(
            new ImportedFqn(new Fqn(ClassDependenciesTest::class), true, null),
        );

        self::assertTrue($classDependencies->hasImportedFqn(new Fqn(ClassDependenciesTest::class)));
        self::assertFalse($classDependencies->hasImportedFqn(new Fqn(ImportedFqnTest::class)));
    }

    /**
     * @test
     */
    public function itShouldGetImportedFqnWithLastPart(): void
    {
        $classDependencies = new ClassDependencies('/Path/To/Class.php');

        $classDependencies->addImportedFqn(
            $importedFqn = new ImportedFqn(new Fqn(ClassDependenciesTest::class), true, null),
        );

        self::assertSame($importedFqn, $classDependencies->getImportedFqnHavingLastPart('ClassDependenciesTest'));
        self::assertNull($classDependencies->getImportedFqnHavingLastPart('ImportedFqnTest'));
    }

    /**
     * @test
     */
    public function itShouldGetImportedFqnWithAlias(): void
    {
        $classDependencies = new ClassDependencies('/Path/To/Class.php');

        $classDependencies->addImportedFqn(
            $importedFqn = new ImportedFqn(new Fqn(ClassDependenciesTest::class), true, 'SomeAlias'),
        );

        self::assertSame($importedFqn, $classDependencies->getImportedFqnHavingAlias('SomeAlias'));
        self::assertNull($classDependencies->getImportedFqnHavingAlias('AnotherAlias'));
    }

    /**
     * @test
     */
    public function itShouldGetAllDependenciesAsList(): void
    {
        $classDependencies = new ClassDependencies('/Path/To/Class.php');

        self::assertSame([], $classDependencies->getInlineFqn());

        $classDependencies->addImportedFqn(
            new ImportedFqn(new Fqn(ClassDependenciesTest::class), true, null),
        );
        $classDependencies->addImportedFqn(
            new ImportedFqn(new Fqn(ImportedFqnTest::class), true, 'alias'),
        );

        $classDependencies->addInlineFqn(new Fqn(ImportedFqn::class));
        $classDependencies->addInlineFqn(new Fqn(Fqn::class));

        self::assertSame([
            Fqn::class,
            ImportedFqn::class,
            ClassDependenciesTest::class,
            ImportedFqnTest::class,
        ], $classDependencies->getDependencyList());
    }
}
