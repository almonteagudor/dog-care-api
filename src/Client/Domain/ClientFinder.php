<?php

declare(strict_types=1);

namespace DogCare\Client\Domain;

use DogCare\Shared\Domain\Criteria\Criteria;
use DogCare\Shared\Domain\Criteria\Filter;
use DogCare\Shared\Domain\Criteria\FilterField;
use DogCare\Shared\Domain\Criteria\FilterOperator;
use DogCare\Shared\Domain\Criteria\Filters;
use DogCare\Shared\Domain\Criteria\FilterValue;
use DogCare\Shared\Domain\Criteria\Order;
use DogCare\Shared\Domain\Exception\NotFoundException;

final readonly class ClientFinder
{
    public function __construct(private ClientRepository $repository)
    {
    }

    public function findById(ClientId $id): Client
    {
        $diseases = $this->repository->match(
            new Criteria(
                new Filters(
                    [
                        new Filter(
                            new FilterField(ClientId::primitiveName()),
                            FilterOperator::EQUAL,
                            new FilterValue($id->value()),

                        ),
                    ],
                ),
                limit: 1,
            ),
        );

        if (count($diseases)) {
            return $diseases[0];
        }

        throw new NotFoundException(Client::primitiveName(), $id->value());
    }

    public function findByCriteria(Filters $filters, ?Order $order, ?int $offset, ?int $limit): array
    {
        return $this->repository->match(new Criteria($filters, $order, $offset, $limit));
    }
}
