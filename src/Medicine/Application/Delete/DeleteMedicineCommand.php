<?php

declare(strict_types=1);

namespace DogCare\Medicine\Application\Delete;

use DogCare\Shared\Domain\Bus\Command\Command;

final readonly class DeleteMedicineCommand implements Command
{
    public function __construct(public string $id)
    {
    }
}
