<?php

declare(strict_types=1);

namespace App\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;
use Doctrine\Migrations\AbstractMigration;
use DogCare\Medicine\Domain\Medicine;
use DogCare\Medicine\Domain\MedicineDescription;
use DogCare\Medicine\Domain\MedicineId;
use DogCare\Medicine\Domain\MedicineName;
use DogCare\Shared\Domain\ValueObject\CreatedAt;
use DogCare\Shared\Domain\ValueObject\DeletedAt;
use DogCare\Shared\Domain\ValueObject\UpdatedAt;

class Version0003CreateMedicineTable extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $diseaseTable = $schema->createTable(Medicine::primitiveName());

        $diseaseTable->addColumn(MedicineId::primitiveName(), Types::GUID, ['notnull' => true, 'length' => 36]);
        $diseaseTable->addColumn(MedicineName::primitiveName(), Types::STRING, ['notnull' => true, 'length' => 50]);
        $diseaseTable->addColumn(
            MedicineDescription::primitiveName(),
            Types::STRING,
            ['notnull' => false, 'length' => 500],
        );
        $diseaseTable->addColumn(CreatedAt::primitiveName(), Types::STRING, ['notnull' => true, 'length' => 30]);
        $diseaseTable->addColumn(UpdatedAt::primitiveName(), Types::STRING, ['notnull' => false, 'length' => 30]);
        $diseaseTable->addColumn(DeletedAt::primitiveName(), Types::STRING, ['notnull' => false, 'length' => 30]);

        $diseaseTable->setPrimaryKey([MedicineId::primitiveName()]);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable(Medicine::primitiveName());
    }
}
