<?php

declare(strict_types=1);

namespace DogCare\Shared\Domain\ValueObject;

final readonly class UpdatedAt extends DateTimeValueObject
{
    public static function primitiveName(): string
    {
        return 'updated_at';
    }
}
