<?php

declare(strict_types=1);

namespace DogCare\Medicine\Application\Create;

use DogCare\Medicine\Domain\Medicine;
use DogCare\Medicine\Domain\MedicineFinder;
use DogCare\Medicine\Domain\MedicineId;
use DogCare\Medicine\Domain\MedicineRepository;
use DogCare\Shared\Domain\Bus\Command\CommandHandler;
use DogCare\Shared\Domain\Exception\AlreadyStoredException;
use DogCare\Shared\Domain\Exception\NotFoundException;

final readonly class CreateMedicineCommandHandler implements CommandHandler
{
    public function __construct(private MedicineRepository $repository, private MedicineFinder $finder)
    {
    }

    public function __invoke(CreateMedicineCommand $command): void
    {
        $id = new MedicineId($command->id);

        try {
            $this->finder->findById($id);

            throw new AlreadyStoredException(Medicine::primitiveName(), $id->value());
        } catch (NotFoundException) {
            Medicine::create($command->id, $command->name, $command->description)->save($this->repository);
        }
    }
}
