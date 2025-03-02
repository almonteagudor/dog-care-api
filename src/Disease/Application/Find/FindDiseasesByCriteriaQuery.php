<?php

declare(strict_types=1);

namespace DogCare\Disease\Application\Find;

use DogCare\Shared\Domain\Bus\Query\Query;

final readonly class FindDiseasesByCriteriaQuery implements Query
{
    public function __construct(
        public array $filters,
        public ?string $orderBy,
        public ?string $order,
        public ?int $offset,
        public ?int $limit,
    ) {
    }
}
