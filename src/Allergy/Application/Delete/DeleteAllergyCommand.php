<?php

declare(strict_types=1);

namespace DogCare\Allergy\Application\Delete;

use DogCare\Shared\Domain\Bus\Command\Command;

final readonly class DeleteAllergyCommand implements Command
{
    public function __construct(public string $id)
    {
    }
}
