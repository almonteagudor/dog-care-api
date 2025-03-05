<?php

declare(strict_types=1);

namespace DogCare\Client\Domain;

use DogCare\Shared\Domain\Exception\MaxLengthValueException;
use DogCare\Shared\Domain\ValueObject\StringValueObject;

final readonly class ClientEmail extends StringValueObject
{
    private const int MAX_LENGTH = 100;

    protected function ensureIsValid(string $value): void
    {
        if (strlen($value) > self::MAX_LENGTH) {
            throw new MaxLengthValueException($value, self::primitiveName(), self::MAX_LENGTH);
        }
    }

    public static function primitiveName(): string
    {
        return 'client_email';
    }
}
