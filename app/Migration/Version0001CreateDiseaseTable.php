<?php

declare(strict_types=1);

namespace App\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;
use Doctrine\Migrations\AbstractMigration;
use DogCare\Disease\Domain\Disease;
use DogCare\Disease\Domain\DiseaseDescription;
use DogCare\Disease\Domain\DiseaseId;
use DogCare\Disease\Domain\DiseaseName;
use DogCare\Shared\Domain\ValueObject\CreatedAt;
use DogCare\Shared\Domain\ValueObject\DeletedAt;
use DogCare\Shared\Domain\ValueObject\UpdatedAt;

class Version0001CreateDiseaseTable extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $diseaseTable = $schema->createTable(Disease::primitiveName());

        $diseaseTable->addColumn(DiseaseId::primitiveName(), Types::GUID, ['notnull' => true, 'length' => 36]);
        $diseaseTable->addColumn(DiseaseName::primitiveName(), Types::STRING, ['notnull' => true, 'length' => 50]);
        $diseaseTable->addColumn(
            DiseaseDescription::primitiveName(),
            Types::STRING,
            ['notnull' => false, 'length' => 500],
        );
        $diseaseTable->addColumn(CreatedAt::primitiveName(), Types::STRING, ['notnull' => true, 'length' => 30]);
        $diseaseTable->addColumn(UpdatedAt::primitiveName(), Types::STRING, ['notnull' => false, 'length' => 30]);
        $diseaseTable->addColumn(DeletedAt::primitiveName(), Types::STRING, ['notnull' => false, 'length' => 30]);

        $diseaseTable->setPrimaryKey([DiseaseId::primitiveName()]);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable(Disease::primitiveName());
    }
}
