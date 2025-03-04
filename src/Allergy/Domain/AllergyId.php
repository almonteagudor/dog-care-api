<?php

declare(strict_types=1);

namespace DogCare\Allergy\Domain;

use DogCare\Shared\Domain\ValueObject\Uuid;

final readonly class AllergyId extends Uuid
{
    public static function primitiveName(): string
    {
        return 'allergy_id';
    }
}
