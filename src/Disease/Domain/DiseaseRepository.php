<?php

declare(strict_types=1);

namespace DogCare\Disease\Domain;

use DogCare\Shared\Domain\Criteria\Criteria;
use DogCare\Shared\Domain\ValueObject\Uuid;

interface DiseaseRepository
{
    /**
     * @return array<Disease>
     */
    public function match(Criteria $criteria): array;

    public function insert(Disease $disease): void;

    public function update(Disease $disease): void;

    public function delete(Uuid $id): void;
}
