<?php

declare(strict_types=1);

namespace App\Tests\Unit\Client\Domain;

use DogCare\Client\Domain\Client;
use DogCare\Client\Domain\ClientEmail;
use DogCare\Client\Domain\ClientId;
use DogCare\Client\Domain\ClientName;
use DogCare\Client\Domain\ClientPhone;
use DogCare\Client\Domain\ClientSurname;
use DogCare\Client\Infrastructure\ClientDoctrineRepository;
use DogCare\Shared\Domain\ValueObject\CreatedAt;
use PHPUnit\Framework\TestCase;

final class ClientTest extends TestCase
{
    public function testClientCreation(): void
    {
        $id = ClientId::random();
        $name = new ClientName('Name');
        $surname = new ClientSurname('Surname');
        $phone = new ClientPhone('Phone');
        $email = new ClientEmail('Email');
        $createdAt = new CreatedAt();

        $client = new Client($id, $name, $surname, $phone, $email, $createdAt);

        $this->assertEquals($id->value(), $client->id->value());
        $this->assertEquals($name->value(), $client->name->value());
        $this->assertEquals($surname->value(), $client->surname->value());
        $this->assertEquals($phone->value(), $client->phone->value());
        $this->assertEquals($email->value(), $client->email->value());
        $this->assertEquals($createdAt->value(), $client->createdAt->value());
    }

    public function testToPrimitives(): void
    {
        $id = ClientId::random();
        $name = new ClientName('Name');
        $surname = new ClientSurname('Surname');
        $phone = new ClientPhone('Phone');
        $email = new ClientEmail('Email');
        $createdAt = new CreatedAt();

        $client = new Client($id, $name, $surname, $phone, $email, $createdAt);
        $primitives = $client->toPrimitives();

        $this->assertEquals($id->value(), $primitives[ClientId::primitiveName()]);
        $this->assertEquals($name->value(), $primitives[ClientName::primitiveName()]);
        $this->assertEquals($surname->value(), $primitives[ClientSurname::primitiveName()]);
        $this->assertEquals($phone->value(), $primitives[ClientPhone::primitiveName()]);
        $this->assertEquals($email->value(), $primitives[ClientEmail::primitiveName()]);
        $this->assertEquals($createdAt->value(), $primitives[CreatedAt::primitiveName()]);
    }

    public function testFromPrimitives(): void
    {
        $data = [
            ClientId::primitiveName() => ClientId::random()->value(),
            ClientName::primitiveName() => 'Name',
            ClientSurname::primitiveName() => 'Surname',
            ClientPhone::primitiveName() => 'Phone',
            ClientEmail::primitiveName() => 'Email',
            CreatedAt::primitiveName() => new CreatedAt()->value(),
        ];

        $client = Client::fromPrimitives($data);

        $this->assertEquals($data[ClientId::primitiveName()], $client->id->value());
        $this->assertEquals($data[ClientName::primitiveName()], $client->name->value());
        $this->assertEquals($data[ClientSurname::primitiveName()], $client->surname->value());
        $this->assertEquals($data[ClientPhone::primitiveName()], $client->phone->value());
        $this->assertEquals($data[ClientEmail::primitiveName()], $client->email->value());
        $this->assertEquals($data[CreatedAt::primitiveName()], $client->createdAt->value());
    }

    public function testUpdateName(): void
    {
        $client = new Client(
            ClientId::random(),
            new ClientName('Name'),
            new ClientSurname('Surname'),
            new ClientPhone('Phone'),
            new ClientEmail('Email'),
            new CreatedAt(),
        );

        $oldUpdatedAt = $client->updatedAt;

        $client->updateName(new ClientName('Name Updated'));

        $this->assertEquals('Name Updated', $client->name->value());
        $this->assertNotEquals($oldUpdatedAt, $client->updatedAt);
    }

    public function testUpdateToSameName(): void
    {
        $client = new Client(
            ClientId::random(),
            new ClientName('Name'),
            new ClientSurname('Surname'),
            new ClientPhone('Phone'),
            new ClientEmail('Email'),
            new CreatedAt(),
        );

        $client->updateName(new ClientName('Name'));

        $this->assertNull($client->updatedAt);
    }

    public function testUpdateSurname(): void
    {
        $client = new Client(
            ClientId::random(),
            new ClientName('Name'),
            new ClientSurname('Surname'),
            new ClientPhone('Phone'),
            new ClientEmail('Email'),
            new CreatedAt(),
        );

        $oldUpdatedAt = $client->updatedAt;

        $client->updateSurname(new ClientSurname('Surname Updated'));

        $this->assertEquals('Surname Updated', $client->surname->value());
        $this->assertNotEquals($oldUpdatedAt, $client->updatedAt);
    }

    public function testUpdateToSameSurname(): void
    {
        $client = new Client(
            ClientId::random(),
            new ClientName('Name'),
            new ClientSurname('Surname'),
            new ClientPhone('Phone'),
            new ClientEmail('Email'),
            new CreatedAt(),
        );

        $client->updateSurname(new ClientSurname('Surname'));

        $this->assertNull($client->updatedAt);
    }

    public function testUpdatePhone(): void
    {
        $client = new Client(
            ClientId::random(),
            new ClientName('Name'),
            new ClientSurname('Surname'),
            new ClientPhone('Phone'),
            new ClientEmail('Email'),
            new CreatedAt(),
        );

        $oldUpdatedAt = $client->updatedAt;

        $client->updatePhone(new ClientPhone('Phone Updated'));

        $this->assertEquals('Phone Updated', $client->phone->value());
        $this->assertNotEquals($oldUpdatedAt, $client->updatedAt);
    }

    public function testUpdateToSamePhone(): void
    {
        $client = new Client(
            ClientId::random(),
            new ClientName('Name'),
            new ClientSurname('Surname'),
            new ClientPhone('Phone'),
            new ClientEmail('Email'),
            new CreatedAt(),
        );

        $client->updatePhone(new ClientPhone('Phone'));

        $this->assertNull($client->updatedAt);
    }

    public function testUpdateEmail(): void
    {
        $client = new Client(
            ClientId::random(),
            new ClientName('Name'),
            new ClientSurname('Surname'),
            new ClientPhone('Phone'),
            new ClientEmail('Email'),
            new CreatedAt(),
        );

        $oldUpdatedAt = $client->updatedAt;

        $client->updateEmail(new ClientEmail('Email Updated'));

        $this->assertEquals('Email Updated', $client->email->value());
        $this->assertNotEquals($oldUpdatedAt, $client->updatedAt);
    }

    public function testUpdateToSameEmail(): void
    {
        $client = new Client(
            ClientId::random(),
            new ClientName('Name'),
            new ClientSurname('Surname'),
            new ClientPhone('Phone'),
            new ClientEmail('Email'),
            new CreatedAt(),
        );

        $client->updateEmail(new ClientEmail('Email'));

        $this->assertNull($client->updatedAt);
    }

    public function testDelete(): void
    {
        $repository = $this->createMock(ClientDoctrineRepository::class);
        $repository->expects($this->once())->method('save');

        $client = new Client(
            ClientId::random(),
            new ClientName('Name'),
            new ClientSurname('Surname'),
            new ClientPhone('Phone'),
            new ClientEmail('Email'),
            new CreatedAt(),
        );

        $client->delete($repository);

        $this->assertNotNull($client->deletedAt);
    }
}
