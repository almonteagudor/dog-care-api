<?php

declare(strict_types=1);

namespace DogCare\Disease\Application\Find;

use DogCare\Shared\Domain\Bus\Query\Query;

final readonly class FindDiseaseQuery implements Query
{
    public function __construct(public string $id)
    {
    }
}
