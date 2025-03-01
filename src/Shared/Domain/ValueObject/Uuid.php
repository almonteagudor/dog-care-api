<?php

declare(strict_types=1);

namespace DogCare\Shared\Domain\ValueObject;

use DogCare\Shared\Domain\Exception\InvalidUuidException;
use Symfony\Component\Uid\Uuid as SymfonyUuid;

abstract readonly class Uuid extends StringValueObject
{
    public static function random(): static
    {
        return new static(SymfonyUuid::v4()->toString());
    }

    protected function ensureIsValid(string $value): void
    {
        if (!SymfonyUuid::isValid($value)) {
            throw new InvalidUuidException($value);
        }
    }
}
