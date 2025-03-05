<?php

namespace App\Tests\DataFixtures\Fixtures;

use App\Tests\DataFixtures\Data\AllergyDataFixture;
use App\Tests\DataFixtures\Data\ClientDataFixture;
use App\Tests\DataFixtures\Data\DiseaseDataFixture;
use App\Tests\DataFixtures\Data\MedicineDataFixture;
use Doctrine\Bundle\FixturesBundle\Fixture as DoctrineFixture;
use Doctrine\DBAL\Connection;
use Doctrine\Persistence\ObjectManager;

class Fixture extends DoctrineFixture
{
    public function __construct(private Connection $connection)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $this->insert(DiseaseDataFixture::tableName(), DiseaseDataFixture::data());
        $this->insert(AllergyDataFixture::tableName(), AllergyDataFixture::data());
        $this->insert(MedicineDataFixture::tableName(), MedicineDataFixture::data());
        $this->insert(ClientDataFixture::tableName(), ClientDataFixture::data());
    }

    private function insert(string $tableName, $data): void
    {
        foreach ($data as $fixture) {
            $this->connection->insert($tableName, $fixture);
        }
    }
}
