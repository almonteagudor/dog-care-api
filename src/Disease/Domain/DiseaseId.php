<?php

declare(strict_types=1);

namespace DogCare\Disease\Domain;

use DogCare\Shared\Domain\ValueObject\Uuid;

final readonly class DiseaseId extends Uuid
{
    public static function primitiveName(): string
    {
        return 'disease_id';
    }
}
