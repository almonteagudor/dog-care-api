<?php

declare(strict_types=1);

namespace DogCare\Client\Application\Delete;

use DogCare\Client\Domain\ClientFinder;
use DogCare\Client\Domain\ClientId;
use DogCare\Client\Domain\ClientRepository;
use DogCare\Shared\Domain\Bus\Command\CommandHandler;

final readonly class DeleteClientCommandHandler implements CommandHandler
{
    public function __construct(private ClientRepository $repository, private ClientFinder $finder)
    {
    }

    public function __invoke(DeleteClientCommand $command): void
    {
        $id = new ClientId($command->id);
        $client = $this->finder->findById($id);

        $client->delete($this->repository);
    }
}
