<?php

declare(strict_types=1);

namespace DogCare\Disease\Infrastructure;

use Doctrine\DBAL\Exception;
use DogCare\Disease\Domain\Disease;
use DogCare\Disease\Domain\DiseaseDescription;
use DogCare\Disease\Domain\DiseaseId;
use DogCare\Disease\Domain\DiseaseName;
use DogCare\Disease\Domain\DiseaseRepository;
use DogCare\Shared\Domain\Criteria\Criteria;
use DogCare\Shared\Domain\ValueObject\CreatedAt;
use DogCare\Shared\Domain\ValueObject\DeletedAt;
use DogCare\Shared\Domain\ValueObject\UpdatedAt;
use DogCare\Shared\Infrastructure\Doctrine\DoctrineRepository;

readonly class DiseaseDoctrineRepository extends DoctrineRepository implements DiseaseRepository
{
    /**
     * @param Criteria $criteria
     * @return array|Disease[]
     * @throws Exception
     */
    public function match(Criteria $criteria): array
    {
        $data = $this->matchInDoctrine($criteria);

        return array_map(fn ($diseaseData) => Disease::fromPrimitives($diseaseData), $data);
    }

    /**
     * @throws Exception
     */
    public function save(Disease $disease): void
    {
        $this->saveInDoctrine($disease);
    }

    /**
     * @throws Exception
     */
    public function delete(DiseaseId $id): void
    {
        $this->deleteInDoctrine($id);
    }

    protected function columnNames(): array
    {
        return [
            DiseaseId::primitiveName(),
            DiseaseName::primitiveName(),
            DiseaseDescription::primitiveName(),
            CreatedAt::primitiveName(),
            UpdatedAt::primitiveName(),
            DeletedAt::primitiveName(),
        ];
    }

    protected function tableName(): string
    {
        return Disease::primitiveName();
    }
}
