<?php

declare(strict_types=1);

namespace DogCare\Client\Application\Find;

use DogCare\Shared\Domain\Bus\Query\Query;

final readonly class FindClientQuery implements Query
{
    public function __construct(public string $id)
    {
    }
}
