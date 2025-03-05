<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller\Client;

use App\Tests\Functional\FunctionalTestCase;
use Doctrine\DBAL\Exception;
use DogCare\Client\Domain\Client;
use DogCare\Client\Domain\ClientEmail;
use DogCare\Client\Domain\ClientId;
use DogCare\Client\Domain\ClientName;
use DogCare\Client\Domain\ClientPhone;
use DogCare\Client\Domain\ClientSurname;
use DogCare\Shared\Domain\ValueObject\DeletedAt;
use Symfony\Component\HttpFoundation\Response;

class DeleteClientControllerTest extends FunctionalTestCase
{
    /**
     * @throws Exception
     */
    public function testDeleteClientNoContentResponse(): void
    {
        $clientData = new Client(
            ClientId::random(),
            new ClientName('Name'),
            new ClientSurname('Surname'),
            new ClientPhone('Phone'),
            new ClientEmail('Email'),
        )->toPrimitives();

        $this->insert(Client::primitiveName(), $clientData);

        $response = $this->httpDelete('delete-client', ['id' => $clientData[ClientId::primitiveName()]]);

        $this->assertEquals(Response::HTTP_NO_CONTENT, $response->getStatusCode());

        $storedClient = $this->findById(Client::primitiveName(), new ClientId($clientData[ClientId::primitiveName()]));

        $this->assertNotNull($storedClient[DeletedAt::primitiveName()]);
    }

    public function testDeleteClientWithRandomIdNotFoundResponse(): void
    {
        $response = $this->httpDelete('put-client', ['id' => ClientId::random()->value()]);

        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->deleteAll(Client::primitiveName());
    }
}
