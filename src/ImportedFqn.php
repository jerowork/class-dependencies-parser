<?php

declare(strict_types=1);

namespace Jerowork\ObjectDependenciesParser;

final class ImportedFqn
{
    public function __construct(
        public readonly Fqn $fqn,
        public bool $isObject,
        public readonly ?string $alias,
    ) {
    }

    public function isNotObject(): void
    {
        $this->isObject = false;
    }
}
