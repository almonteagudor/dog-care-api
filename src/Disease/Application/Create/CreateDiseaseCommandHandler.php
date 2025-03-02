<?php

declare(strict_types=1);

namespace DogCare\Disease\Application\Create;

use DogCare\Disease\Domain\Disease;
use DogCare\Disease\Domain\DiseaseFinder;
use DogCare\Disease\Domain\DiseaseId;
use DogCare\Disease\Domain\DiseaseRepository;
use DogCare\Shared\Domain\Bus\Command\CommandHandler;
use DogCare\Shared\Domain\Exception\AlreadyStoredException;
use DogCare\Shared\Domain\Exception\NotFoundException;

final readonly class CreateDiseaseCommandHandler implements CommandHandler
{
    public function __construct(private DiseaseRepository $repository, private DiseaseFinder $finder)
    {
    }

    public function __invoke(CreateDiseaseCommand $command): void
    {
        $id = new DiseaseId($command->id);

        try {
            $this->finder->findById($id);

            throw new AlreadyStoredException(Disease::primitiveName(), $id->value());
        } catch (NotFoundException) {
            Disease::create($command->id, $command->name, $command->description)->save($this->repository);
        }
    }
}
