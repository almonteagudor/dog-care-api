<?php

declare(strict_types=1);

namespace DogCare\Shared\Domain\ValueObject;

final readonly class DeletedAt extends DateTimeValueObject
{
    public static function primitiveName(): string
    {
        return 'deleted_at';
    }
}
