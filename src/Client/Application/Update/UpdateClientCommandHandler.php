<?php

declare(strict_types=1);

namespace DogCare\Client\Application\Update;

use DogCare\Client\Domain\ClientEmail;
use DogCare\Client\Domain\ClientFinder;
use DogCare\Client\Domain\ClientId;
use DogCare\Client\Domain\ClientName;
use DogCare\Client\Domain\ClientPhone;
use DogCare\Client\Domain\ClientRepository;
use DogCare\Client\Domain\ClientSurname;
use DogCare\Shared\Domain\Bus\Command\CommandHandler;

final readonly class UpdateClientCommandHandler implements CommandHandler
{
    public function __construct(private ClientRepository $repository, private ClientFinder $finder)
    {
    }

    public function __invoke(UpdateClientCommand $command): void
    {
        $id = new ClientId($command->id);

        $disease = $this->finder->findById($id);

        $disease->updateName(new ClientName($command->name));
        $disease->updateSurname(new ClientSurname($command->surname));
        $disease->updatePhone(new ClientPhone($command->phone));
        $disease->updateEmail(new ClientEmail($command->email));

        $disease->save($this->repository);
    }
}
