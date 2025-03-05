<?php

declare(strict_types=1);

namespace DogCare\Medicine\Application\Find;

use DogCare\Shared\Domain\Bus\Query\Query;

final readonly class FindMedicineQuery implements Query
{
    public function __construct(public string $id)
    {
    }
}
