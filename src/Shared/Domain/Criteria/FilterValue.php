<?php

declare(strict_types=1);

namespace DogCare\Shared\Domain\Criteria;

use DogCare\Shared\Domain\ValueObject\StringValueObject;

final readonly class FilterValue extends StringValueObject
{
    public static function primitiveName(): string
    {
        return 'filter_value';
    }

    protected function ensureIsValid(string $value): void
    {
    }
}
