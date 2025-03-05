<?php

declare(strict_types=1);

namespace DogCare\Client\Domain;

use DogCare\Shared\Domain\Criteria\Criteria;

interface ClientRepository
{
    /**
     * @return array<Client>
     */
    public function match(Criteria $criteria): array;

    public function save(Client $disease): void;

    public function delete(ClientId $id): void;
}
