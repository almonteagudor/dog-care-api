<?php

declare(strict_types=1);

namespace DogCare\Medicine\Domain;

use DogCare\Shared\Domain\ValueObject\Uuid;

final readonly class MedicineId extends Uuid
{
    public static function primitiveName(): string
    {
        return 'medicine_id';
    }
}
