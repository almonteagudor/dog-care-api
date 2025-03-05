<?php

declare(strict_types=1);

namespace DogCare\Client\Application\Find;

use DogCare\Client\Domain\Client;
use DogCare\Client\Domain\ClientFinder;
use DogCare\Shared\Domain\Bus\Query\QueryHandler;
use DogCare\Shared\Domain\Criteria\Filters;
use DogCare\Shared\Domain\Criteria\Order;

final readonly class FindClientsByCriteriaQueryHandler implements QueryHandler
{
    public function __construct(public ClientFinder $finder)
    {
    }

    public function __invoke(FindClientsByCriteriaQuery $query): ClientsResponse
    {
        $diseases = $this->finder->findByCriteria(
            Filters::fromValues($query->filters),
            Order::fromValues($query->orderBy, $query->order),
            $query->limit,
            $query->offset,
        );

        return new ClientsResponse(
            array_map(fn (Client $disease) => ClientResponse::fromClient($disease), $diseases),
        );
    }
}
