<?php

namespace App\Tests\DataFixtures\Fixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\DBAL\Connection;
use Doctrine\Persistence\ObjectManager;
use DogCare\Disease\Domain\Disease;
use DogCare\Disease\Domain\DiseaseDescription;
use DogCare\Disease\Domain\DiseaseId;
use DogCare\Disease\Domain\DiseaseName;
use DogCare\Shared\Domain\ValueObject\CreatedAt;

class AppFixtures extends Fixture
{
    public function __construct(private Connection $connection)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $this->connection->insert(Disease::primitiveName(), [
            DiseaseId::primitiveName() => DiseaseId::random()->value(),
            DiseaseName::primitiveName() => 'Name',
            DiseaseDescription::primitiveName() => 'Description',
            CreatedAt::primitiveName() => (new CreatedAt())->value(),
        ]);
    }
}
