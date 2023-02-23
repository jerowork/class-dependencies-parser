<?php

declare(strict_types=1);

namespace Jerowork\ClassDependenciesParser;

final class ImportedFqn
{
    public function __construct(
        public readonly Fqn $fqn,
        public bool $isClass,
        public readonly ?string $alias,
    ) {
    }

    public function isNotClass(): void
    {
        $this->isClass = false;
    }
}
