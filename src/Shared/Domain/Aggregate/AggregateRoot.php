<?php

declare(strict_types=1);

namespace DogCare\Shared\Domain\Aggregate;

use DogCare\Shared\Domain\ValueObject\Uuid;

abstract class AggregateRoot
{
    public static abstract function primitiveName(): string;

    /**
     * @param array<string, mixed> $data
     */
    public abstract static function fromPrimitives(array $data): self;

    public abstract function id(): Uuid;

    /**
     * @return array<string, mixed>
     */
    public abstract function toPrimitives(): array;
}
