<?php

declare(strict_types=1);

namespace DogCare\Shared\Infrastructure\Doctrine;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use DogCare\Shared\Domain\Aggregate\AggregateRoot;
use DogCare\Shared\Domain\Criteria\Criteria;
use DogCare\Shared\Domain\Criteria\Filter;
use DogCare\Shared\Domain\Criteria\FilterField;
use DogCare\Shared\Domain\Criteria\FilterOperator;
use DogCare\Shared\Domain\Criteria\Filters;
use DogCare\Shared\Domain\Criteria\FilterValue;
use DogCare\Shared\Domain\ValueObject\Uuid;

abstract readonly class DoctrineRepository
{
    public function __construct(private Connection $connection)
    {
    }

    /**
     * @return array<string, mixed>
     * @throws Exception
     */
    protected function matchInDoctrine(Criteria $criteria): array
    {
        $queryBuilder = $this->connection
            ->createQueryBuilder()
            ->select(... $this->columnNames())
            ->from($this->tableName());

        $queryBuilder = new DbalCriteriaConverter([$queryBuilder])->convert($criteria, $queryBuilder);

        return $queryBuilder->fetchAllAssociative();
    }

    /**
     * @throws Exception
     */
    protected function saveInDoctrine(AggregateRoot $aggregateRoot): void
    {
        if ($this->exists($aggregateRoot)) {
            $this->update($aggregateRoot);
        } else {
            $this->insert($aggregateRoot);
        }
    }

    /**
     * @throws Exception
     */
    public function deleteInDoctrine(Uuid $uuid): void
    {
        $this->connection->delete($this->tableName(), [$uuid->primitiveName(), $uuid->value()]);
    }

    /**
     * @return array<string>
     */
    abstract protected function columnNames(): array;

    abstract protected function tableName(): string;

    /**
     * @throws Exception
     */
    private function insert(AggregateRoot $aggregateRoot): void
    {
        $this->connection->insert($this->tableName(), $this->aggregateToColumns($aggregateRoot));
    }

    /**
     * @throws Exception
     */
    private function update(AggregateRoot $aggregateRoot): void
    {
        $this->connection->update(
            $this->tableName(),
            $this->aggregateToColumns($aggregateRoot),
            [$aggregateRoot->id->primitiveName(), $aggregateRoot->id->value()],
        );
    }

    /**
     * @throws Exception
     */
    private function exists(AggregateRoot $aggregateRoot): bool
    {
        $data = $this->matchInDoctrine(
            new Criteria(
                new Filters(
                    [
                        new Filter(
                            new FilterField($aggregateRoot->id->primitiveName()),
                            FilterOperator::EQUAL,
                            new FilterValue($aggregateRoot->id->value()),
                        ),
                    ],
                ),
            ),
        );

        return count($data) > 0;
    }

    private function aggregateToColumns(AggregateRoot $aggregateRoot): array
    {
        $aggregatePrimitives = $aggregateRoot->toPrimitives();

        $columns = [];

        foreach ($this->columnNames() as $columnName) {
            if (array_key_exists($columnName, $aggregatePrimitives)) {
                $columns[$columnName] = $aggregatePrimitives[$columnName];
            }
        }

        return $columns;
    }
}
