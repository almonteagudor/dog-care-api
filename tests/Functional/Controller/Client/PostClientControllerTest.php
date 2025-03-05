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
use Symfony\Component\HttpFoundation\Response;

class PostClientControllerTest extends FunctionalTestCase
{
    /**
     * @throws Exception
     */
    public function testPostClientCreatedResponse(): void
    {
        $client = new Client(
            ClientId::random(),
            new ClientName('Name'),
            new ClientSurname('Surname'),
            new ClientPhone('Phone'),
            new ClientEmail('Email'),
        );

        $response = $this->httpPost(
            'post-client',
            ['id' => $client->id->value()],
            $client->toPrimitives(),
        );

        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());

        $storedClient = $this->findById(Client::primitiveName(), $client->id);

        $this->assertEquals($client->id->value(), $storedClient[ClientId::primitiveName()]);
        $this->assertEquals($client->name->value(), $storedClient[ClientName::primitiveName()]);
        $this->assertEquals($client->surname->value(), $storedClient[ClientSurname::primitiveName()]);
        $this->assertEquals($client->phone->value(), $storedClient[ClientPhone::primitiveName()]);
        $this->assertEquals($client->email->value(), $storedClient[ClientEmail::primitiveName()]);
    }

    public function testPostClientWithoutNameBadRequestResponse(): void
    {
        $clientData = new Client(
            ClientId::random(),
            new ClientName('Name'),
            new ClientSurname('Surname'),
            new ClientPhone('Phone'),
            new ClientEmail('Email'),
        )->toPrimitives();

        unset($clientData[ClientName::primitiveName()]);

        $response = $this->httpPost(
            'post-client',
            ['id' => $clientData[ClientId::primitiveName()]],
            $clientData,
        );

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function testPostClientWithNullNameBadRequestResponse(): void
    {
        $clientData = new Client(
            ClientId::random(),
            new ClientName('Name'),
            new ClientSurname('Surname'),
            new ClientPhone('Phone'),
            new ClientEmail('Email'),
        )->toPrimitives();

        $clientData[ClientName::primitiveName()] = null;

        $response = $this->httpPost(
            'post-client',
            ['id' => $clientData[ClientId::primitiveName()]],
            $clientData,
        );

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function testPostClientWithoutSurnameBadRequestResponse(): void
    {
        $clientData = new Client(
            ClientId::random(),
            new ClientName('Name'),
            new ClientSurname('Surname'),
            new ClientPhone('Phone'),
            new ClientEmail('Email'),
        )->toPrimitives();

        unset($clientData[ClientSurname::primitiveName()]);

        $response = $this->httpPost(
            'post-client',
            ['id' => $clientData[ClientId::primitiveName()]],
            $clientData,
        );

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function testPostClientWithNullSurnameBadRequestResponse(): void
    {
        $clientData = new Client(
            ClientId::random(),
            new ClientName('Name'),
            new ClientSurname('Surname'),
            new ClientPhone('Phone'),
            new ClientEmail('Email'),
        )->toPrimitives();

        $clientData[ClientSurname::primitiveName()] = null;

        $response = $this->httpPost(
            'post-client',
            ['id' => $clientData[ClientId::primitiveName()]],
            $clientData,
        );

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function testPostClientWithoutPhoneBadRequestResponse(): void
    {
        $clientData = new Client(
            ClientId::random(),
            new ClientName('Name'),
            new ClientSurname('Surname'),
            new ClientPhone('Phone'),
            new ClientEmail('Email'),
        )->toPrimitives();

        unset($clientData[ClientPhone::primitiveName()]);

        $response = $this->httpPost(
            'post-client',
            ['id' => $clientData[ClientId::primitiveName()]],
            $clientData,
        );

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function testPostClientWithNullPhoneBadRequestResponse(): void
    {
        $clientData = new Client(
            ClientId::random(),
            new ClientName('Name'),
            new ClientSurname('Surname'),
            new ClientPhone('Phone'),
            new ClientEmail('Email'),
        )->toPrimitives();

        $clientData[ClientPhone::primitiveName()] = null;

        $response = $this->httpPost(
            'post-client',
            ['id' => $clientData[ClientId::primitiveName()]],
            $clientData,
        );

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function testPostClientWithoutEmailBadRequestResponse(): void
    {
        $clientData = new Client(
            ClientId::random(),
            new ClientName('Name'),
            new ClientSurname('Surname'),
            new ClientPhone('Phone'),
            new ClientEmail('Email'),
        )->toPrimitives();

        unset($clientData[ClientEmail::primitiveName()]);

        $response = $this->httpPost(
            'post-client',
            ['id' => $clientData[ClientId::primitiveName()]],
            $clientData,
        );

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function testPostClientWithNullEmailBadRequestResponse(): void
    {
        $clientData = new Client(
            ClientId::random(),
            new ClientName('Name'),
            new ClientSurname('Surname'),
            new ClientPhone('Phone'),
            new ClientEmail('Email'),
        )->toPrimitives();

        $clientData[ClientEmail::primitiveName()] = null;

        $response = $this->httpPost(
            'post-client',
            ['id' => $clientData[ClientId::primitiveName()]],
            $clientData,
        );

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->deleteAll(Client::primitiveName());
    }
}
