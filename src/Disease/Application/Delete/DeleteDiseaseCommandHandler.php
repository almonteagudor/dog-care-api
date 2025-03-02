<?php

declare(strict_types=1);

namespace DogCare\Disease\Application\Delete;

use DogCare\Disease\Domain\Disease;
use DogCare\Disease\Domain\DiseaseDescription;
use DogCare\Disease\Domain\DiseaseFinder;
use DogCare\Disease\Domain\DiseaseId;
use DogCare\Disease\Domain\DiseaseName;
use DogCare\Disease\Domain\DiseaseRepository;
use DogCare\Shared\Domain\Bus\Command\CommandHandler;
use DogCare\Shared\Domain\Exception\NotFoundException;

final readonly class DeleteDiseaseCommandHandler implements CommandHandler
{
    public function __construct(private DiseaseRepository $repository, private DiseaseFinder $finder)
    {
    }

    public function __invoke(DeleteDiseaseCommand $command): void
    {
        $id = new DiseaseId($command->id);
        $disease = $this->finder->findById($id);

        $disease->delete($this->repository);
    }
}
