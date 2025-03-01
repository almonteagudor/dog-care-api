<?php

declare(strict_types=1);

namespace DogCare\Shared\Domain\ValueObject;

abstract readonly class BoolValueObject extends ValueObject
{
    public function __construct(protected bool $value)
    {
    }

    public function value(): bool
    {
        return $this->value;
    }
}
