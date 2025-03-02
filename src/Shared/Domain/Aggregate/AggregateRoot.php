<?php

declare(strict_types=1);

namespace DogCare\Shared\Domain\Aggregate;

use DogCare\Shared\Domain\ValueObject\Uuid;

abstract class AggregateRoot
{
    public function __construct(
        private(set) readonly Uuid $id,
    ) {
    }

    public static abstract function primitiveName(): string;

    /**
     * @param array<string, mixed> $data
     */
    public abstract static function fromPrimitives(array $data): self;

    /**
     * @return array<string, mixed>
     */
    public abstract function toPrimitives(): array;
}
