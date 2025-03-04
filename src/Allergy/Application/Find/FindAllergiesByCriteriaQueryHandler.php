<?php

declare(strict_types=1);

namespace DogCare\Allergy\Application\Find;

use DogCare\Allergy\Domain\Allergy;
use DogCare\Allergy\Domain\AllergyFinder;
use DogCare\Shared\Domain\Bus\Query\QueryHandler;
use DogCare\Shared\Domain\Criteria\Filters;
use DogCare\Shared\Domain\Criteria\Order;

final readonly class FindAllergiesByCriteriaQueryHandler implements QueryHandler
{
    public function __construct(public AllergyFinder $finder)
    {
    }

    public function __invoke(FindAllergiesByCriteriaQuery $query): AllergiesResponse
    {
        $allergies = $this->finder->findByCriteria(
            Filters::fromValues($query->filters),
            Order::fromValues($query->orderBy, $query->order),
            $query->limit,
            $query->offset,
        );

        return new AllergiesResponse(
            array_map(fn (Allergy $allergy) => AllergyResponse::fromAllergy($allergy), $allergies),
        );
    }
}
