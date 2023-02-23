<?php

declare(strict_types=1);

namespace Jerowork\ClassDependenciesParser;

final class ClassDependencies
{
    private ?Fqn $fqn = null;

    /** @var array<string, ImportedFqn> */
    private array $importedFqn = [];

    /** @var array<string, Fqn> */
    private array $inlineFqn = [];

    public function __construct(
        public readonly string $filePath,
    ) {
    }

    public function setFqn(Fqn $fqn): void
    {
        $this->fqn = $fqn;
    }

    public function addImportedFqn(ImportedFqn $importedFqn): void
    {
        $this->importedFqn[(string) $importedFqn->fqn] = $importedFqn;
    }

    public function addInlineFqn(Fqn $fqn): void
    {
        $this->inlineFqn[(string) $fqn] = $fqn;
    }

    public function hasImportedFqn(Fqn $fqn): bool
    {
        foreach ($this->importedFqn as $import) {
            if ($import->fqn->equals($fqn)) {
                return true;
            }
        }

        return false;
    }

    public function getImportedFqnHavingLastPart(string $lastPart): ?ImportedFqn
    {
        foreach ($this->importedFqn as $import) {
            if ($import->fqn->getLastPart() === $lastPart) {
                return $import;
            }
        }

        return null;
    }

    public function getImportedFqnHavingAlias(string $alias): ?ImportedFqn
    {
        foreach ($this->importedFqn as $import) {
            if ($import->alias === $alias) {
                return $import;
            }
        }

        return null;
    }

    public function getFqn(): ?Fqn
    {
        return $this->fqn;
    }

    /**
     * @return array<string, ImportedFqn>
     */
    public function getImportedFqn(): array
    {
        return $this->importedFqn;
    }

    /**
     * @return array<string, Fqn>
     */
    public function getInlineFqn(): array
    {
        return $this->inlineFqn;
    }

    /**
     * @return list<string>
     */
    public function getDependencyList(): array
    {
        $dependencies = [
            ...array_keys(array_filter($this->importedFqn, static fn (ImportedFqn $fqcn): bool => $fqcn->isClass)),
            ...array_keys($this->inlineFqn),
        ];

        sort($dependencies);

        return $dependencies;
    }
}
