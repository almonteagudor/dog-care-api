<?php

declare(strict_types=1);

namespace DogCare\Client\Application\Find;

use DogCare\Client\Domain\Client;
use DogCare\Client\Domain\ClientEmail;
use DogCare\Client\Domain\ClientId;
use DogCare\Client\Domain\ClientName;
use DogCare\Client\Domain\ClientPhone;
use DogCare\Client\Domain\ClientSurname;
use DogCare\Shared\Domain\Bus\Query\Response;

final readonly class ClientResponse implements Response
{

    public function __construct(
        private string $id,
        private string $name,
        private string $surname,
        private string $phone,
        private string $email,
    ) {
    }

    public static function fromClient(Client $client): self
    {
        return new self(
            $client->id->value(),
            $client->name->value(),
            $client->surname->value(),
            $client->phone->value(),
            $client->email->value(),
        );
    }

    public function toPrimitives(): array
    {
        return [
            ClientId::primitiveName() => $this->id,
            ClientName::primitiveName() => $this->name,
            ClientSurname::primitiveName() => $this->surname,
            ClientPhone::primitiveName() => $this->phone,
            ClientEmail::primitiveName() => $this->email,
        ];
    }
}
