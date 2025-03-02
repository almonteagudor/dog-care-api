<?php

declare(strict_types=1);

namespace DogCare\Shared\Infrastructure\Bus\Query;

use DogCare\Shared\Domain\Bus\Query\Query;
use DogCare\Shared\Domain\Bus\Query\QueryBus;
use DogCare\Shared\Domain\Bus\Query\QueryHandler;
use DogCare\Shared\Domain\Bus\Query\Response;

final readonly class InMemoryQueryBus implements QueryBus
{
    /**
     * @param iterable<QueryHandler> $queryHandlers
     */
    public function __construct(private iterable $queryHandlers)
    {
    }

    public function ask(Query $query): Response
    {
        foreach ($this->queryHandlers as $handler) {
            if ($handler::class === $query::class . 'Handler') {
                return $handler($query);
            }
        }

        throw new QueryNotRegisteredException($query);
    }
}
