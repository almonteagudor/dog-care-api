<?php

declare(strict_types=1);

namespace DogCare\Allergy\Infrastructure;

use Doctrine\DBAL\Exception;
use DogCare\Allergy\Domain\Allergy;
use DogCare\Allergy\Domain\AllergyDescription;
use DogCare\Allergy\Domain\AllergyId;
use DogCare\Allergy\Domain\AllergyName;
use DogCare\Allergy\Domain\AllergyRepository;
use DogCare\Shared\Domain\Criteria\Criteria;
use DogCare\Shared\Domain\ValueObject\CreatedAt;
use DogCare\Shared\Domain\ValueObject\DeletedAt;
use DogCare\Shared\Domain\ValueObject\UpdatedAt;
use DogCare\Shared\Infrastructure\Doctrine\DoctrineRepository;

readonly class AllergyDoctrineRepository extends DoctrineRepository implements AllergyRepository
{
    /**
     * @param Criteria $criteria
     * @return array|Allergy[]
     * @throws Exception
     */
    public function match(Criteria $criteria): array
    {
        $data = $this->matchInDoctrine($criteria);

        return array_map(fn ($diseaseData) => Allergy::fromPrimitives($diseaseData), $data);
    }

    /**
     * @throws Exception
     */
    public function save(Allergy $disease): void
    {
        $this->saveInDoctrine($disease);
    }

    /**
     * @throws Exception
     */
    public function delete(AllergyId $id): void
    {
        $this->deleteInDoctrine($id);
    }

    protected function columnNames(): array
    {
        return [
            AllergyId::primitiveName(),
            AllergyName::primitiveName(),
            AllergyDescription::primitiveName(),
            CreatedAt::primitiveName(),
            UpdatedAt::primitiveName(),
            DeletedAt::primitiveName(),
        ];
    }

    protected function tableName(): string
    {
        return Allergy::primitiveName();
    }
}
