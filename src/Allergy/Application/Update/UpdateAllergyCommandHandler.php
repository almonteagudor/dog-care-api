<?php

declare(strict_types=1);

namespace DogCare\Allergy\Application\Update;

use DogCare\Allergy\Domain\AllergyDescription;
use DogCare\Allergy\Domain\AllergyFinder;
use DogCare\Allergy\Domain\AllergyId;
use DogCare\Allergy\Domain\AllergyName;
use DogCare\Allergy\Domain\AllergyRepository;
use DogCare\Shared\Domain\Bus\Command\CommandHandler;

final readonly class UpdateAllergyCommandHandler implements CommandHandler
{
    public function __construct(private AllergyRepository $repository, private AllergyFinder $finder)
    {
    }

    public function __invoke(UpdateAllergyCommand $command): void
    {
        $id = new AllergyId($command->id);

        $allergy = $this->finder->findById($id);

        $allergy->updateName(new AllergyName($command->name));
        $allergy->updateDescription($command->description ? new AllergyDescription($command->description) : null);

        $allergy->save($this->repository);
    }
}
