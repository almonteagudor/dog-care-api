<?php

declare(strict_types=1);

namespace DogCare\Allergy\Domain;

use DogCare\Shared\Domain\Criteria\Criteria;

interface AllergyRepository
{
    /**
     * @return array<Allergy>
     */
    public function match(Criteria $criteria): array;

    public function save(Allergy $disease): void;

    public function delete(AllergyId $id): void;
}
