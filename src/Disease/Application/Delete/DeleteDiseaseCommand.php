<?php

declare(strict_types=1);

namespace DogCare\Disease\Application\Delete;

use DogCare\Shared\Domain\Bus\Command\Command;

final readonly class DeleteDiseaseCommand implements Command
{
    public function __construct(public string $id)
    {
    }
}
