<?php

declare(strict_types=1);

namespace DogCare\Client\Application\Create;

use DogCare\Client\Domain\Client;
use DogCare\Client\Domain\ClientFinder;
use DogCare\Client\Domain\ClientId;
use DogCare\Client\Domain\ClientRepository;
use DogCare\Shared\Domain\Bus\Command\CommandHandler;
use DogCare\Shared\Domain\Exception\AlreadyStoredException;
use DogCare\Shared\Domain\Exception\NotFoundException;

final readonly class CreateClientCommandHandler implements CommandHandler
{
    public function __construct(private ClientRepository $repository, private ClientFinder $finder)
    {
    }

    public function __invoke(CreateClientCommand $command): void
    {
        $id = new ClientId($command->id);

        try {
            $this->finder->findById($id);

            throw new AlreadyStoredException(Client::primitiveName(), $id->value());
        } catch (NotFoundException) {
            Client::create(
                $command->id,
                $command->name,
                $command->surname,
                $command->phone,
                $command->email,
            )->save($this->repository);
        }
    }
}
