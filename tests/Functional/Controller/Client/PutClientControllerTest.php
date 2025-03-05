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
use DogCare\Shared\Domain\ValueObject\UpdatedAt;
use Symfony\Component\HttpFoundation\Response;

class PutClientControllerTest extends FunctionalTestCase
{
    /**
     * @throws Exception
     */
    public function testPutClientUpdateNameOkResponse(): void
    {
        $clientData = new Client(
            ClientId::random(),
            new ClientName('Name'),
            new ClientSurname('Surname'),
            new ClientPhone('Phone'),
            new ClientEmail('Email'),
        )->toPrimitives();

        $this->insert(Client::primitiveName(), $clientData);

        $clientData[ClientName::primitiveName()] = 'Name Updated';

        $response = $this->httpPut(
            'put-client',
            ['id' => $clientData[ClientId::primitiveName()]],
            $clientData,
        );

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());

        $storedClient = $this->findById(Client::primitiveName(), new ClientId($clientData[ClientId::primitiveName()]));

        $this->assertEquals($clientData[ClientName::primitiveName()], $storedClient[ClientName::primitiveName()]);
        $this->assertNotNull($storedClient[UpdatedAt::primitiveName()]);
    }

    public function testPutClientUpdateWithoutNameBadRequestResponse(): void
    {
        $clientData = new Client(
            ClientId::random(),
            new ClientName('Name'),
            new ClientSurname('Surname'),
            new ClientPhone('Phone'),
            new ClientEmail('Email'),
        )->toPrimitives();

        $this->insert(Client::primitiveName(), $clientData);

        unset($clientData[ClientName::primitiveName()]);

        $response = $this->httpPut(
            'put-client',
            ['id' => $clientData[ClientId::primitiveName()]],
            $clientData,
        );

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function testPutClientUpdateWithNullNameBadRequestResponse(): void
    {
        $clientData = new Client(
            ClientId::random(),
            new ClientName('Name'),
            new ClientSurname('Surname'),
            new ClientPhone('Phone'),
            new ClientEmail('Email'),
        )->toPrimitives();

        $this->insert(Client::primitiveName(), $clientData);

        $clientData[ClientName::primitiveName()] = null;

        $response = $this->httpPut(
            'put-client',
            ['id' => $clientData[ClientId::primitiveName()]],
            $clientData,
        );

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    /**
     * @throws Exception
     */
    public function testPutClientUpdateSurnameOkResponse(): void
    {
        $clientData = new Client(
            ClientId::random(),
            new ClientName('Name'),
            new ClientSurname('Surname'),
            new ClientPhone('Phone'),
            new ClientEmail('Email'),
        )->toPrimitives();

        $this->insert(Client::primitiveName(), $clientData);

        $clientData[ClientSurname::primitiveName()] = 'Surname Updated';

        $response = $this->httpPut(
            'put-client',
            ['id' => $clientData[ClientId::primitiveName()]],
            $clientData,
        );

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());

        $storedClient = $this->findById(Client::primitiveName(), new ClientId($clientData[ClientId::primitiveName()]));

        $this->assertEquals($clientData[ClientSurname::primitiveName()], $storedClient[ClientSurname::primitiveName()]);
        $this->assertNotNull($storedClient[UpdatedAt::primitiveName()]);
    }

    public function testPutClientUpdateWithoutSurnameBadRequestResponse(): void
    {
        $clientData = new Client(
            ClientId::random(),
            new ClientName('Name'),
            new ClientSurname('Surname'),
            new ClientPhone('Phone'),
            new ClientEmail('Email'),
        )->toPrimitives();

        $this->insert(Client::primitiveName(), $clientData);

        unset($clientData[ClientSurname::primitiveName()]);

        $response = $this->httpPut(
            'put-client',
            ['id' => $clientData[ClientId::primitiveName()]],
            $clientData,
        );

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function testPutClientUpdateWithNullSurnameBadRequestResponse(): void
    {
        $clientData = new Client(
            ClientId::random(),
            new ClientName('Name'),
            new ClientSurname('Surname'),
            new ClientPhone('Phone'),
            new ClientEmail('Email'),
        )->toPrimitives();

        $this->insert(Client::primitiveName(), $clientData);

        $clientData[ClientSurname::primitiveName()] = null;

        $response = $this->httpPut(
            'put-client',
            ['id' => $clientData[ClientId::primitiveName()]],
            $clientData,
        );

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    /**
     * @throws Exception
     */
    public function testPutClientUpdatePhoneOkResponse(): void
    {
        $clientData = new Client(
            ClientId::random(),
            new ClientName('Name'),
            new ClientSurname('Surname'),
            new ClientPhone('Phone'),
            new ClientEmail('Email'),
        )->toPrimitives();

        $this->insert(Client::primitiveName(), $clientData);

        $clientData[ClientPhone::primitiveName()] = 'Phone Updated';

        $response = $this->httpPut(
            'put-client',
            ['id' => $clientData[ClientId::primitiveName()]],
            $clientData,
        );

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());

        $storedClient = $this->findById(Client::primitiveName(), new ClientId($clientData[ClientId::primitiveName()]));

        $this->assertEquals($clientData[ClientPhone::primitiveName()], $storedClient[ClientPhone::primitiveName()]);
        $this->assertNotNull($storedClient[UpdatedAt::primitiveName()]);
    }

    public function testPutClientUpdateWithoutPhoneBadRequestResponse(): void
    {
        $clientData = new Client(
            ClientId::random(),
            new ClientName('Name'),
            new ClientSurname('Surname'),
            new ClientPhone('Phone'),
            new ClientEmail('Email'),
        )->toPrimitives();

        $this->insert(Client::primitiveName(), $clientData);

        unset($clientData[ClientPhone::primitiveName()]);

        $response = $this->httpPut(
            'put-client',
            ['id' => $clientData[ClientId::primitiveName()]],
            $clientData,
        );

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function testPutClientUpdateWithNullPhoneBadRequestResponse(): void
    {
        $clientData = new Client(
            ClientId::random(),
            new ClientName('Name'),
            new ClientSurname('Surname'),
            new ClientPhone('Phone'),
            new ClientEmail('Email'),
        )->toPrimitives();

        $this->insert(Client::primitiveName(), $clientData);

        $clientData[ClientPhone::primitiveName()] = null;

        $response = $this->httpPut(
            'put-client',
            ['id' => $clientData[ClientId::primitiveName()]],
            $clientData,
        );

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    /**
     * @throws Exception
     */
    public function testPutClientUpdateEmailOkResponse(): void
    {
        $clientData = new Client(
            ClientId::random(),
            new ClientName('Name'),
            new ClientSurname('Surname'),
            new ClientPhone('Phone'),
            new ClientEmail('Email'),
        )->toPrimitives();

        $this->insert(Client::primitiveName(), $clientData);

        $clientData[ClientEmail::primitiveName()] = 'Email Updated';

        $response = $this->httpPut(
            'put-client',
            ['id' => $clientData[ClientId::primitiveName()]],
            $clientData,
        );

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());

        $storedClient = $this->findById(Client::primitiveName(), new ClientId($clientData[ClientId::primitiveName()]));

        $this->assertEquals($clientData[ClientEmail::primitiveName()], $storedClient[ClientEmail::primitiveName()]);
        $this->assertNotNull($storedClient[UpdatedAt::primitiveName()]);
    }

    public function testPutClientUpdateWithoutEmailBadRequestResponse(): void
    {
        $clientData = new Client(
            ClientId::random(),
            new ClientName('Name'),
            new ClientSurname('Surname'),
            new ClientPhone('Phone'),
            new ClientEmail('Email'),
        )->toPrimitives();

        $this->insert(Client::primitiveName(), $clientData);

        unset($clientData[ClientEmail::primitiveName()]);

        $response = $this->httpPut(
            'put-client',
            ['id' => $clientData[ClientId::primitiveName()]],
            $clientData,
        );

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function testPutClientUpdateWithNullEmailBadRequestResponse(): void
    {
        $clientData = new Client(
            ClientId::random(),
            new ClientName('Name'),
            new ClientSurname('Surname'),
            new ClientPhone('Phone'),
            new ClientEmail('Email'),
        )->toPrimitives();

        $this->insert(Client::primitiveName(), $clientData);

        $clientData[ClientEmail::primitiveName()] = null;

        $response = $this->httpPut(
            'put-client',
            ['id' => $clientData[ClientId::primitiveName()]],
            $clientData,
        );

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function testPutClientWithRandomIdNotFoundResponse(): void
    {
        $clientData = new Client(
            ClientId::random(),
            new ClientName('Name'),
            new ClientSurname('Surname'),
            new ClientPhone('Phone'),
            new ClientEmail('Email'),
        )->toPrimitives();

        $response = $this->httpPut(
            'put-client',
            ['id' => $clientData[ClientId::primitiveName()]],
            $clientData,
        );

        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->deleteAll(Client::primitiveName());
    }
}
