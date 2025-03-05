<?php

declare(strict_types=1);

namespace DogCare\Medicine\Application\Find;

use DogCare\Medicine\Domain\MedicineFinder;
use DogCare\Medicine\Domain\MedicineId;
use DogCare\Shared\Domain\Bus\Query\QueryHandler;

final readonly class FindMedicineQueryHandler implements QueryHandler
{
    public function __construct(public MedicineFinder $finder)
    {
    }

    public function __invoke(FindMedicineQuery $query): MedicineResponse
    {
        $medicine = $this->finder->findById(new MedicineId($query->id));

        return MedicineResponse::fromMedicine($medicine);
    }
}
