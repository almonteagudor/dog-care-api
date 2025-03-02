<?php

declare(strict_types=1);

namespace DogCare\Shared\Domain\ValueObject;

abstract readonly class ValueObject
{
    public function equals(?object $other): bool
    {
        return $other instanceof (static::class) && $this->value() === $other->value();
    }

    public static abstract function primitiveName(): string;

    public abstract function value(): mixed;
}
