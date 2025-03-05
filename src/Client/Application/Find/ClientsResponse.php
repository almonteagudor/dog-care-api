<?php

declare(strict_types=1);

namespace DogCare\Client\Application\Find;

use DogCare\Shared\Domain\Bus\Query\Response;

final readonly class ClientsResponse implements Response
{
    /**
     * @param array<ClientResponse> $clientResponses
     */
    public function __construct(private array $clientResponses)
    {
    }

    public function toPrimitives(): array
    {
        return array_map(fn (ClientResponse $response) => $response->toPrimitives(), $this->clientResponses);
    }
}
