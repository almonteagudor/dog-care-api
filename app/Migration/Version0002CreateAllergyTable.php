<?php

declare(strict_types=1);

namespace App\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;
use Doctrine\Migrations\AbstractMigration;
use DogCare\Allergy\Domain\Allergy;
use DogCare\Allergy\Domain\AllergyDescription;
use DogCare\Allergy\Domain\AllergyId;
use DogCare\Allergy\Domain\AllergyName;
use DogCare\Shared\Domain\ValueObject\CreatedAt;
use DogCare\Shared\Domain\ValueObject\DeletedAt;
use DogCare\Shared\Domain\ValueObject\UpdatedAt;

class Version0002CreateAllergyTable extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $diseaseTable = $schema->createTable(Allergy::primitiveName());

        $diseaseTable->addColumn(AllergyId::primitiveName(), Types::GUID, ['notnull' => true, 'length' => 36]);
        $diseaseTable->addColumn(AllergyName::primitiveName(), Types::STRING, ['notnull' => true, 'length' => 50]);
        $diseaseTable->addColumn(
            AllergyDescription::primitiveName(),
            Types::STRING,
            ['notnull' => false, 'length' => 500],
        );
        $diseaseTable->addColumn(CreatedAt::primitiveName(), Types::STRING, ['notnull' => true, 'length' => 30]);
        $diseaseTable->addColumn(UpdatedAt::primitiveName(), Types::STRING, ['notnull' => false, 'length' => 30]);
        $diseaseTable->addColumn(DeletedAt::primitiveName(), Types::STRING, ['notnull' => false, 'length' => 30]);

        $diseaseTable->setPrimaryKey([AllergyId::primitiveName()]);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable(Allergy::primitiveName());
    }
}
