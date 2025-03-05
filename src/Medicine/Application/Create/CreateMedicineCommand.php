<?php

declare(strict_types=1);

namespace DogCare\Medicine\Application\Create;

use DogCare\Shared\Domain\Bus\Command\Command;

final readonly class CreateMedicineCommand implements Command
{
    public function __construct(public string $id, public string $name, public ?string $description)
    {
    }
}
