<?php

declare(strict_types=1);

namespace App\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;
use Doctrine\Migrations\AbstractMigration;
use DogCare\Client\Domain\Client;
use DogCare\Client\Domain\ClientDescription;
use DogCare\Client\Domain\ClientEmail;
use DogCare\Client\Domain\ClientId;
use DogCare\Client\Domain\ClientName;
use DogCare\Client\Domain\ClientPhone;
use DogCare\Client\Domain\ClientSurname;
use DogCare\Shared\Domain\ValueObject\CreatedAt;
use DogCare\Shared\Domain\ValueObject\DeletedAt;
use DogCare\Shared\Domain\ValueObject\UpdatedAt;

class Version0004CreateClientTable extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $diseaseTable = $schema->createTable(Client::primitiveName());

        $diseaseTable->addColumn(ClientId::primitiveName(), Types::GUID, ['notnull' => true, 'length' => 36]);
        $diseaseTable->addColumn(ClientName::primitiveName(), Types::STRING, ['notnull' => true, 'length' => 50]);
        $diseaseTable->addColumn(ClientSurname::primitiveName(), Types::STRING, ['notnull' => true, 'length' => 100]);
        $diseaseTable->addColumn(ClientPhone::primitiveName(), Types::STRING, ['notnull' => true, 'length' => 15]);
        $diseaseTable->addColumn(ClientEmail::primitiveName(), Types::STRING, ['notnull' => true, 'length' => 100]);
        $diseaseTable->addColumn(CreatedAt::primitiveName(), Types::STRING, ['notnull' => true, 'length' => 30]);
        $diseaseTable->addColumn(UpdatedAt::primitiveName(), Types::STRING, ['notnull' => false, 'length' => 30]);
        $diseaseTable->addColumn(DeletedAt::primitiveName(), Types::STRING, ['notnull' => false, 'length' => 30]);

        $diseaseTable->setPrimaryKey([ClientId::primitiveName()]);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable(Client::primitiveName());
    }
}
