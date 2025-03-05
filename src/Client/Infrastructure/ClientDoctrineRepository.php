<?php

declare(strict_types=1);

namespace DogCare\Client\Infrastructure;

use Doctrine\DBAL\Exception;
use DogCare\Client\Domain\Client;
use DogCare\Client\Domain\ClientEmail;
use DogCare\Client\Domain\ClientId;
use DogCare\Client\Domain\ClientName;
use DogCare\Client\Domain\ClientPhone;
use DogCare\Client\Domain\ClientRepository;
use DogCare\Client\Domain\ClientSurname;
use DogCare\Shared\Domain\Criteria\Criteria;
use DogCare\Shared\Domain\ValueObject\CreatedAt;
use DogCare\Shared\Domain\ValueObject\DeletedAt;
use DogCare\Shared\Domain\ValueObject\UpdatedAt;
use DogCare\Shared\Infrastructure\Doctrine\DoctrineRepository;

readonly class ClientDoctrineRepository extends DoctrineRepository implements ClientRepository
{
    /**
     * @param Criteria $criteria
     * @return array|Client[]
     * @throws Exception
     */
    public function match(Criteria $criteria): array
    {
        $data = $this->matchInDoctrine($criteria);

        return array_map(fn ($diseaseData) => Client::fromPrimitives($diseaseData), $data);
    }

    /**
     * @throws Exception
     */
    public function save(Client $disease): void
    {
        $this->saveInDoctrine($disease);
    }

    /**
     * @throws Exception
     */
    public function delete(ClientId $id): void
    {
        $this->deleteInDoctrine($id);
    }

    protected function columnNames(): array
    {
        return [
            ClientId::primitiveName(),
            ClientName::primitiveName(),
            ClientSurname::primitiveName(),
            ClientPhone::primitiveName(),
            ClientEmail::primitiveName(),
            CreatedAt::primitiveName(),
            UpdatedAt::primitiveName(),
            DeletedAt::primitiveName(),
        ];
    }

    protected function tableName(): string
    {
        return Client::primitiveName();
    }
}
