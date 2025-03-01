<?php

declare(strict_types=1);

namespace DogCare\Shared\Domain\Criteria;

use DogCare\Shared\Domain\ValueObject\StringValueObject;

final readonly class OrderBy extends StringValueObject
{
    public static function primitiveName(): string
    {
        return 'order_by';
    }

    protected function ensureIsValid(string $value): void
    {
    }
}
