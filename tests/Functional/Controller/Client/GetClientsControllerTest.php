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

class GetClientsControllerTest extends FunctionalTestCase
{
    public function testGetClients(): void
    {
        $firstClient = new Client(
            ClientId::random(),
            new ClientName('first_name'),
            new ClientSurname('first_surname'),
            new ClientPhone('first_phone'),
            new ClientEmail('first_email'),
        );

        $secondClient = new Client(
            ClientId::random(),
            new ClientName('second_name'),
            new ClientSurname('second_surname'),
            new ClientPhone('second_phone'),
            new ClientEmail('second_email'),
        );

        $this->insert(Client::primitiveName(), $firstClient->toPrimitives());
        $this->insert(Client::primitiveName(), $secondClient->toPrimitives());

        $response = $this->httpGet('get-clients');

        $responseData = json_decode($response->getContent(), true);

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertIsArray($responseData);
        $this->assertCount(2, $responseData);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->deleteAll(Client::primitiveName());
    }
}
