<?php

namespace App\Tests\DataFixtures\Fixtures;

use App\Tests\DataFixtures\Data\DiseaseDataFixture;
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
    }

    private function insert(string $tableName, $data): void
    {
        foreach ($data as $fixture) {
            $this->connection->insert($tableName, $fixture);
        }
    }
}
