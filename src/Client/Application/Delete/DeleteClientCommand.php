<?php

declare(strict_types=1);

namespace DogCare\Client\Application\Delete;

use DogCare\Shared\Domain\Bus\Command\Command;

final readonly class DeleteClientCommand implements Command
{
    public function __construct(public string $id)
    {
    }
}
