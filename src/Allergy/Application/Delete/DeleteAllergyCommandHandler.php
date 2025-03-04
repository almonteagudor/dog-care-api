<?php

declare(strict_types=1);

namespace DogCare\Allergy\Application\Delete;

use DogCare\Allergy\Domain\AllergyFinder;
use DogCare\Allergy\Domain\AllergyId;
use DogCare\Allergy\Domain\AllergyRepository;
use DogCare\Shared\Domain\Bus\Command\CommandHandler;

final readonly class DeleteAllergyCommandHandler implements CommandHandler
{
    public function __construct(private AllergyRepository $repository, private AllergyFinder $finder)
    {
    }

    public function __invoke(DeleteAllergyCommand $command): void
    {
        $id = new AllergyId($command->id);
        $allergy = $this->finder->findById($id);

        $allergy->delete($this->repository);
    }
}
