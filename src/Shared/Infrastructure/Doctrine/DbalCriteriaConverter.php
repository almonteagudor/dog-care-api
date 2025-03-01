<?php

declare(strict_types=1);

namespace DogCare\Shared\Infrastructure\Doctrine;

use Doctrine\DBAL\Query\QueryBuilder;
use DogCare\Shared\Domain\Criteria\Criteria;
use DogCare\Shared\Domain\Criteria\FilterField;
use DogCare\Shared\Domain\Criteria\Filters;
use DogCare\Shared\Domain\Criteria\Order;
use InvalidArgumentException;
use function array_key_exists;

final readonly class DbalCriteriaConverter
{
    /**
     * @param array<string, callable> $hydrators
     */
    public function __construct(private array $hydrators = [])
    {
    }

    /**
     * @param array<int, array<string, string>> $joins
     */
    public function convert(Criteria $criteria, QueryBuilder $queryBuilder, array $joins = []): QueryBuilder
    {
        $this->applyJoins($queryBuilder, $joins);
        $this->applyFilters($criteria->filters(), $queryBuilder);
        $this->applyOrder($criteria->order(), $queryBuilder);
        $this->applyPagination($criteria, $queryBuilder);

        return $queryBuilder;
    }

    /**
     * @param array<int, array<string, string>> $joins
     */
    private function applyJoins(QueryBuilder $queryBuilder, array $joins): void
    {
        foreach ($joins as $join) {
            $joinType = $join['type'] ?? 'left';
            $parentAlias = $this->findParentAliasFromCondition($join['condition'], $join['alias']);

            $queryBuilder->{$joinType . 'Join'}(
                $parentAlias,
                $join['table'],
                $join['alias'],
                $join['condition'],
            );
        }
    }

    private function findParentAliasFromCondition(string $condition, string $currentAlias): string
    {
        if (preg_match_all('/([a-z_]+)\.\w+/', $condition, $matches)) {
            foreach ($matches[1] as $alias) {
                if ($alias !== $currentAlias) {
                    return $alias;
                }
            }
        }

        throw new InvalidArgumentException(
            "Could not determine the parent alias for alias '$currentAlias' using condition: '$condition'.",
        );
    }

    private function applyFilters(Filters $filters, QueryBuilder $queryBuilder): void
    {
        foreach ($filters->filters() as $filter) {
            $field = $filter->field()->value();
            $value = $this->existsHydratorFor($field)
                ? $this->hydrate($field, $filter->value()->value())
                : $filter->value()->value();

            $operator = $filter->operator()->value;

            $queryBuilder->andWhere(
                $queryBuilder->expr()->comparison($field, $operator, $queryBuilder->createNamedParameter($value)),
            );
        }
    }

    private function existsHydratorFor(string $field): bool
    {
        return array_key_exists($field, $this->hydrators);
    }

    private function hydrate(string $field, string $value): mixed
    {
        return $this->hydrators[$field]($value);
    }

    private function applyOrder(Order $order, QueryBuilder $queryBuilder): void
    {
        if ($order->isNone()) {
            return;
        }

        $queryBuilder->orderBy(
            new FilterField($order->orderBy()->value())->value(),
            $order->orderType()->value,
        );
    }

    private function applyPagination(Criteria $criteria, QueryBuilder $queryBuilder): void
    {
        if ($criteria->hasOffset()) {
            $queryBuilder->setFirstResult($criteria->offset());
        }

        if ($criteria->hasLimit()) {
            $queryBuilder->setMaxResults($criteria->limit());
        }
    }
}
