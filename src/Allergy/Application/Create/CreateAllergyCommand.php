<?php

declare(strict_types=1);

namespace DogCare\Allergy\Application\Create;

use DogCare\Shared\Domain\Bus\Command\Command;

final readonly class CreateAllergyCommand implements Command
{
    public function __construct(public string $id, public string $name, public ?string $description)
    {
    }
}
