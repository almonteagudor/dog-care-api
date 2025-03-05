<?php

declare(strict_types=1);

namespace DogCare\Client\Application\Create;

use DogCare\Shared\Domain\Bus\Command\Command;

final readonly class CreateClientCommand implements Command
{
    public function __construct(
        public string $id,
        public string $name,
        public string $surname,
        public string $phone,
        public string $email,
    ) {
    }
}
