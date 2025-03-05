<?php

declare(strict_types=1);

namespace DogCare\Medicine\Application\Update;

use DogCare\Medicine\Domain\MedicineDescription;
use DogCare\Medicine\Domain\MedicineFinder;
use DogCare\Medicine\Domain\MedicineId;
use DogCare\Medicine\Domain\MedicineName;
use DogCare\Medicine\Domain\MedicineRepository;
use DogCare\Shared\Domain\Bus\Command\CommandHandler;

final readonly class UpdateMedicineCommandHandler implements CommandHandler
{
    public function __construct(private MedicineRepository $repository, private MedicineFinder $finder)
    {
    }

    public function __invoke(UpdateMedicineCommand $command): void
    {
        $id = new MedicineId($command->id);

        $medicine = $this->finder->findById($id);

        $medicine->updateName(new MedicineName($command->name));
        $medicine->updateDescription($command->description ? new MedicineDescription($command->description) : null);

        $medicine->save($this->repository);
    }
}
