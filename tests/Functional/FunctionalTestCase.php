<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use DogCare\Shared\Domain\ValueObject\Uuid;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

abstract class FunctionalTestCase extends WebTestCase
{
    protected KernelBrowser $client;

    protected function setUp(): void
    {
        $this->client = $this->client ?? static::createClient();
    }

    /**
     * @param array<string, string> $parameters
     */
    protected function httpGet(string $routeName, array $parameters = []): Response
    {
        $uri = $this->client->getContainer()->get('router')->generate($routeName, $parameters);

        $this->client->request('GET', $uri);

        return $this->client->getResponse();
    }

    /**
     * @param array<string, string> $parameters
     * @param array<string, mixed> $body
     */
    protected function httpPost(string $routeName, array $parameters = [], array $body = []): Response
    {
        $uri = $this->client->getContainer()->get('router')->generate($routeName, $parameters);

        $this->client->request(
            'POST',
            $uri,
            server: ['CONTENT_TYPE' => 'application/json'],
            content: json_encode($body),
        );

        return $this->client->getResponse();
    }

    /**
     * @return array<string, string>
     * @throws Exception
     */
    protected function findById(string $tableName, Uuid $id): array
    {
        /** @var Connection $connection */
        $connection = $this->client->getContainer()->get('doctrine')->getConnection();

        $data = $connection->executeQuery(
            'SELECT * FROM ' . $tableName . ' WHERE ' . $id::primitiveName() . ' = :id',
            ['id' => $id->value()],
        )->fetchAllAssociative();

        if (count($data)) {
            return $data[0];
        }

        return [];
    }


    protected function insert(string $tableName, $data): void
    {
        /** @var Connection $connection */
        $connection = $this->client->getContainer()->get('doctrine')->getConnection();

        $connection->insert($tableName, $data);
    }

    protected function deleteAll(string $tableName): void
    {
        /** @var Connection $connection */
        $connection = $this->client->getContainer()->get('doctrine')->getConnection();

        $connection->delete($tableName);
    }
}
