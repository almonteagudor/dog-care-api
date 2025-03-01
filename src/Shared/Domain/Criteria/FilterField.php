<?php

declare(strict_types=1);

namespace DogCare\Shared\Domain\Criteria;

use DogCare\Shared\Domain\ValueObject\StringValueObject;

final readonly class FilterField extends StringValueObject
{
    public static function primitiveName(): string
    {
        return 'filter_field';
    }

    protected function ensureIsValid(string $value): void
    {
    }
}
