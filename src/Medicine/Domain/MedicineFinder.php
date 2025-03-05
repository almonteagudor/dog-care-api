<?php

declare(strict_types=1);

namespace DogCare\Medicine\Domain;

use DogCare\Shared\Domain\Criteria\Criteria;
use DogCare\Shared\Domain\Criteria\Filter;
use DogCare\Shared\Domain\Criteria\FilterField;
use DogCare\Shared\Domain\Criteria\FilterOperator;
use DogCare\Shared\Domain\Criteria\Filters;
use DogCare\Shared\Domain\Criteria\FilterValue;
use DogCare\Shared\Domain\Criteria\Order;
use DogCare\Shared\Domain\Exception\NotFoundException;

final readonly class MedicineFinder
{
    public function __construct(private MedicineRepository $repository)
    {
    }

    public function findById(MedicineId $id): Medicine
    {
        $medicines = $this->repository->match(
            new Criteria(
                new Filters(
                    [
                        new Filter(
                            new FilterField(MedicineId::primitiveName()),
                            FilterOperator::EQUAL,
                            new FilterValue($id->value()),

                        ),
                    ],
                ),
                limit: 1,
            ),
        );

        if (count($medicines)) {
            return $medicines[0];
        }

        throw new NotFoundException(Medicine::primitiveName(), $id->value());
    }

    public function findByCriteria(Filters $filters, ?Order $order, ?int $offset, ?int $limit): array
    {
        return $this->repository->match(new Criteria($filters, $order, $offset, $limit));
    }
}
