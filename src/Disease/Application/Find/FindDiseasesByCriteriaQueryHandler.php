<?php

declare(strict_types=1);

namespace DogCare\Disease\Application\Find;

use DogCare\Disease\Domain\Disease;
use DogCare\Disease\Domain\DiseaseFinder;
use DogCare\Shared\Domain\Bus\Query\QueryHandler;
use DogCare\Shared\Domain\Criteria\Filters;
use DogCare\Shared\Domain\Criteria\Order;

final readonly class FindDiseasesByCriteriaQueryHandler implements QueryHandler
{
    public function __construct(public DiseaseFinder $finder)
    {
    }

    public function __invoke(FindDiseasesByCriteriaQuery $query): DiseasesResponse
    {
        $diseases = $this->finder->findByCriteria(
            Filters::fromValues($query->filters),
            Order::fromValues($query->orderBy, $query->order),
            $query->limit,
            $query->offset,
        );

        return new DiseasesResponse(
            array_map(fn (Disease $disease) => DiseaseResponse::fromDisease($disease), $diseases),
        );
    }
}
