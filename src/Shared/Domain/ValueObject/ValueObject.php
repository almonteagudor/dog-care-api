<?php

declare(strict_types=1);

namespace DogCare\Shared\Domain\ValueObject;

abstract readonly class ValueObject
{
    public function equals(self $other): bool
    {
        return $this->primitiveName() === $other->primitiveName() && $this->value() === $other->value();
    }

    public static abstract function primitiveName(): string;

    public abstract function value(): mixed;
}
