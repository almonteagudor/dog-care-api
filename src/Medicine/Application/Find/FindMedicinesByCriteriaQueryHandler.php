<?php

declare(strict_types=1);

namespace DogCare\Medicine\Application\Find;

use DogCare\Medicine\Domain\Medicine;
use DogCare\Medicine\Domain\MedicineFinder;
use DogCare\Shared\Domain\Bus\Query\QueryHandler;
use DogCare\Shared\Domain\Criteria\Filters;
use DogCare\Shared\Domain\Criteria\Order;

final readonly class FindMedicinesByCriteriaQueryHandler implements QueryHandler
{
    public function __construct(public MedicineFinder $finder)
    {
    }

    public function __invoke(FindMedicinesByCriteriaQuery $query): MedicinesResponse
    {
        $medicines = $this->finder->findByCriteria(
            Filters::fromValues($query->filters),
            Order::fromValues($query->orderBy, $query->order),
            $query->limit,
            $query->offset,
        );

        return new MedicinesResponse(
            array_map(fn (Medicine $medicine) => MedicineResponse::fromMedicine($medicine), $medicines),
        );
    }
}
