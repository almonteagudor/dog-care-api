<?php

declare(strict_types=1);

namespace App\Tests\DataFixtures\Data;

use DogCare\Client\Domain\Client;
use DogCare\Client\Domain\ClientEmail;
use DogCare\Client\Domain\ClientId;
use DogCare\Client\Domain\ClientName;
use DogCare\Client\Domain\ClientPhone;
use DogCare\Client\Domain\ClientSurname;
use DogCare\Shared\Domain\ValueObject\CreatedAt;

class ClientDataFixture extends DataFixture
{
    public static function tableName(): string
    {
        return Client::primitiveName();
    }

    public static function data(): array
    {
        return [
            [
                ClientId::primitiveName() => '35f476f0-8462-40d2-99e2-c1ab42bbe722',
                ClientName::primitiveName() => 'Alberto',
                ClientSurname::primitiveName() => 'Monteagudo Rodríguez',
                ClientPhone::primitiveName() => '111 11 11 11',
                ClientEmail::primitiveName() => 'albertomonteagudo@email.com',
                CreatedAt::primitiveName() => new CreatedAt()->value(),
            ],
            [
                ClientId::primitiveName() => '59ce9e8c-cf21-468d-844b-71bb22c125c1',
                ClientName::primitiveName() => 'María',
                ClientSurname::primitiveName() => 'Dolores Delgado',
                ClientPhone::primitiveName() => '222 22 22 22',
                ClientEmail::primitiveName() => 'mariadolores@email.com',
                CreatedAt::primitiveName() => new CreatedAt()->value(),
            ],
            [
                ClientId::primitiveName() => 'b6090630-1d94-45bb-b886-8623f40d4f6b',
                ClientName::primitiveName() => 'Saphira',
                ClientSurname::primitiveName() => 'Monteagudo Delgado',
                ClientPhone::primitiveName() => '333 33 33 33',
                ClientEmail::primitiveName() => 'saphiramonteagudo@email.com',
                CreatedAt::primitiveName() => new CreatedAt()->value(),
            ],
        ];
    }
}
