<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller\Client;

use App\Tests\Functional\FunctionalTestCase;
use DogCare\Client\Domain\Client;
use DogCare\Client\Domain\ClientEmail;
use DogCare\Client\Domain\ClientId;
use DogCare\Client\Domain\ClientName;
use DogCare\Client\Domain\ClientPhone;
use DogCare\Client\Domain\ClientSurname;
use Symfony\Component\HttpFoundation\Response;

class GetClientControllerTest extends FunctionalTestCase
{
    public function testGetClientOkResponse(): void
    {
        $client = new Client(
            ClientId::random(),
            new ClientName('name'),
            new ClientSurname('Surname'),
            new ClientPhone('Phone'),
            new ClientEmail('Email'),
        );

        $this->insert(Client::primitiveName(), $client->toPrimitives());

        $response = $this->httpGet('get-client', ['id' => $client->id->value()]);

        $responseData = json_decode($response->getContent(), true);

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertEquals($client->id->value(), $responseData[ClientId::primitiveName()]);
        $this->assertEquals($client->name->value(), $responseData[ClientName::primitiveName()]);
        $this->assertEquals($client->surname->value(), $responseData[ClientSurname::primitiveName()]);
        $this->assertEquals($client->phone->value(), $responseData[ClientPhone::primitiveName()]);
        $this->assertEquals($client->email->value(), $responseData[ClientEmail::primitiveName()]);
    }

    public function testGetClientWithRandomIdNotFoundResponse(): void
    {
        $response = $this->httpGet('get-client', ['id' => ClientId::random()->value()]);

        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->deleteAll(Client::primitiveName());
    }
}
