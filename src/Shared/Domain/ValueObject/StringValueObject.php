<?php

declare(strict_types=1);

namespace DogCare\Shared\Domain\ValueObject;

abstract readonly class StringValueObject extends ValueObject
{
    public function __construct(protected string $value)
    {
        $this->ensureIsValid($value);
    }

    protected abstract function ensureIsValid(string $value): void;

    public function value(): string
    {
        return $this->value;
    }
}
