<?php

declare(strict_types=1);

namespace DogCare\Medicine\Application\Delete;

use DogCare\Medicine\Domain\MedicineFinder;
use DogCare\Medicine\Domain\MedicineId;
use DogCare\Medicine\Domain\MedicineRepository;
use DogCare\Shared\Domain\Bus\Command\CommandHandler;

final readonly class DeleteMedicineCommandHandler implements CommandHandler
{
    public function __construct(private MedicineRepository $repository, private MedicineFinder $finder)
    {
    }

    public function __invoke(DeleteMedicineCommand $command): void
    {
        $id = new MedicineId($command->id);
        $medicine = $this->finder->findById($id);

        $medicine->delete($this->repository);
    }
}
