<?php

declare(strict_types=1);

namespace DogCare\Medicine\Infrastructure;

use Doctrine\DBAL\Exception;
use DogCare\Medicine\Domain\Medicine;
use DogCare\Medicine\Domain\MedicineDescription;
use DogCare\Medicine\Domain\MedicineId;
use DogCare\Medicine\Domain\MedicineName;
use DogCare\Medicine\Domain\MedicineRepository;
use DogCare\Shared\Domain\Criteria\Criteria;
use DogCare\Shared\Domain\ValueObject\CreatedAt;
use DogCare\Shared\Domain\ValueObject\DeletedAt;
use DogCare\Shared\Domain\ValueObject\UpdatedAt;
use DogCare\Shared\Infrastructure\Doctrine\DoctrineRepository;

readonly class MedicineDoctrineRepository extends DoctrineRepository implements MedicineRepository
{
    /**
     * @param Criteria $criteria
     * @return array|Medicine[]
     * @throws Exception
     */
    public function match(Criteria $criteria): array
    {
        $data = $this->matchInDoctrine($criteria);

        return array_map(fn ($diseaseData) => Medicine::fromPrimitives($diseaseData), $data);
    }

    /**
     * @throws Exception
     */
    public function save(Medicine $disease): void
    {
        $this->saveInDoctrine($disease);
    }

    /**
     * @throws Exception
     */
    public function delete(MedicineId $id): void
    {
        $this->deleteInDoctrine($id);
    }

    protected function columnNames(): array
    {
        return [
            MedicineId::primitiveName(),
            MedicineName::primitiveName(),
            MedicineDescription::primitiveName(),
            CreatedAt::primitiveName(),
            UpdatedAt::primitiveName(),
            DeletedAt::primitiveName(),
        ];
    }

    protected function tableName(): string
    {
        return Medicine::primitiveName();
    }
}
