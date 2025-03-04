<?php

declare(strict_types=1);

namespace DogCare\Allergy\Application\Create;

use DogCare\Allergy\Domain\Allergy;
use DogCare\Allergy\Domain\AllergyFinder;
use DogCare\Allergy\Domain\AllergyId;
use DogCare\Allergy\Domain\AllergyRepository;
use DogCare\Shared\Domain\Bus\Command\CommandHandler;
use DogCare\Shared\Domain\Exception\AlreadyStoredException;
use DogCare\Shared\Domain\Exception\NotFoundException;

final readonly class CreateAllergyCommandHandler implements CommandHandler
{
    public function __construct(private AllergyRepository $repository, private AllergyFinder $finder)
    {
    }

    public function __invoke(CreateAllergyCommand $command): void
    {
        $id = new AllergyId($command->id);

        try {
            $this->finder->findById($id);

            throw new AlreadyStoredException(Allergy::primitiveName(), $id->value());
        } catch (NotFoundException) {
            Allergy::create($command->id, $command->name, $command->description)->save($this->repository);
        }
    }
}
