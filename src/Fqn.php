<?php

declare(strict_types=1);

namespace Jerowork\ObjectDependenciesParser;

use Stringable;

final class Fqn implements Stringable
{
    private const NAMESPACE_DIVIDER = '\\';

    public function __construct(
        public readonly string $fqn,
    ) {
    }

    /**
     * @param list<string> $parts
     */
    public static function createFromParts(array $parts): self
    {
        return new self(implode(self::NAMESPACE_DIVIDER, $parts));
    }

    public function __toString(): string
    {
        return $this->fqn;
    }

    /**
     * @return list<string>
     */
    public function getParts(): array
    {
        return explode(self::NAMESPACE_DIVIDER, $this->fqn);
    }

    public function getFullFqnWithoutLastPart(): string
    {
        $parts = $this->getParts();
        array_pop($parts);

        return implode(self::NAMESPACE_DIVIDER, $parts);
    }

    public function getLastPart(): string
    {
        $parts = $this->getParts();

        return (string) array_pop($parts);
    }

    public function equals(self $that): bool
    {
        return $this->fqn === $that->fqn;
    }
}
