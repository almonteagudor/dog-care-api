<?php

declare(strict_types=1);

namespace DogCare\Allergy\Application\Find;

use DogCare\Shared\Domain\Bus\Query\Query;

final readonly class FindAllergyQuery implements Query
{
    public function __construct(public string $id)
    {
    }
}
