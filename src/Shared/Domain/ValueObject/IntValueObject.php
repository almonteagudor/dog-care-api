<?php

declare(strict_types=1);

namespace DogCare\Shared\Domain\ValueObject;

abstract readonly class IntValueObject extends ValueObject
{
    public function __construct(protected int $value)
    {
        $this->ensureIsValid($value);
    }

    protected abstract function ensureIsValid(int $value): void;

    public function value(): int
    {
        return $this->value;
    }
}
