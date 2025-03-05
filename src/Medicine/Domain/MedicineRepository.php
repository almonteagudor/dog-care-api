<?php

declare(strict_types=1);

namespace DogCare\Medicine\Domain;

use DogCare\Shared\Domain\Criteria\Criteria;

interface MedicineRepository
{
    /**
     * @return array<Medicine>
     */
    public function match(Criteria $criteria): array;

    public function save(Medicine $disease): void;

    public function delete(MedicineId $id): void;
}
