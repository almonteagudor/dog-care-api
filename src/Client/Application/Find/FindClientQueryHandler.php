<?php

declare(strict_types=1);

namespace DogCare\Client\Application\Find;

use DogCare\Client\Domain\ClientFinder;
use DogCare\Client\Domain\ClientId;
use DogCare\Shared\Domain\Bus\Query\QueryHandler;

final readonly class FindClientQueryHandler implements QueryHandler
{
    public function __construct(public ClientFinder $finder)
    {
    }

    public function __invoke(FindClientQuery $query): ClientResponse
    {
        $disease = $this->finder->findById(new ClientId($query->id));

        return ClientResponse::fromClient($disease);
    }
}
