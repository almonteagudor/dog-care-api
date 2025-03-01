<?php

declare(strict_types=1);

namespace DogCare\Shared\Domain\ValueObject;

final readonly class CreatedAt extends DateTimeValueObject
{
    public static function primitiveName(): string
    {
        return 'created_at';
    }
}
