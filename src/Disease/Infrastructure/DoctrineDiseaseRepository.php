<?php

declare(strict_types=1);

namespace DogCare\Disease\Infrastructure;

use Doctrine\DBAL\Connection;
use DogCare\Disease\Domain\Disease;
use DogCare\Disease\Domain\DiseaseDescription;
use DogCare\Disease\Domain\DiseaseId;
use DogCare\Disease\Domain\DiseaseName;
use DogCare\Disease\Domain\DiseaseRepository;
use DogCare\Shared\Domain\Criteria\Criteria;
use DogCare\Shared\Domain\ValueObject\CreatedAt;
use DogCare\Shared\Domain\ValueObject\DeletedAt;
use DogCare\Shared\Domain\ValueObject\UpdatedAt;
use DogCare\Shared\Domain\ValueObject\Uuid;
use DogCare\Shared\Infrastructure\Doctrine\DbalCriteriaConverter;

final readonly class DoctrineDiseaseRepository implements DiseaseRepository
{
    public function __construct(private Connection $connection)
    {
    }

    public function match(Criteria $criteria): array
    {
        $queryBuilder = $this->connection
            ->createQueryBuilder()
            ->select(... $this->fields())
            ->from(Disease::primitiveName());

        $queryBuilder = (new DbalCriteriaConverter([$queryBuilder]))->convert($criteria, $queryBuilder);

        $data = $queryBuilder->fetchAllAssociative();

        return array_map(fn ($diseaseData) => Disease::fromPrimitives($diseaseData), $data);
    }

    /**
     * @return array<string>
     */
    private function fields(): array
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

    public function insert(Disease $disease): void
    {
        $this->connection->insert(Disease::primitiveName(), $disease->toPrimitives());
    }

    public function update(Disease $disease): void
    {
        $this->connection->update(
            Disease::primitiveName(),
            $disease->toPrimitives(),
            [DiseaseId::primitiveName(), $disease->id()->value()],
        );
    }

    public function delete(Uuid $id): void
    {
        $this->connection->delete(Disease::primitiveName(), [DiseaseId::primitiveName(), $id->value()]);
    }
}
