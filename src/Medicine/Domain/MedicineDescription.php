<?php

declare(strict_types=1);

namespace DogCare\Medicine\Domain;

use DogCare\Shared\Domain\Exception\MaxLengthValueException;
use DogCare\Shared\Domain\ValueObject\StringValueObject;

final readonly class MedicineDescription extends StringValueObject
{
    private const int MAX_LENGTH = 500;

    protected function ensureIsValid(string $value): void
    {
        if (strlen($value) > self::MAX_LENGTH) {
            throw new MaxLengthValueException($value, self::primitiveName(), self::MAX_LENGTH);
        }
    }

    public static function primitiveName(): string
    {
        return 'medicine_description';
    }
}
