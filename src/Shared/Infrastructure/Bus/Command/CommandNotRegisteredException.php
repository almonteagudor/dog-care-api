<?php

declare(strict_types=1);

namespace DogCare\Shared\Infrastructure\Bus\Command;

use DogCare\Shared\Domain\Bus\Command\Command;
use RuntimeException;

final class CommandNotRegisteredException extends RuntimeException
{
    public function __construct(Command $command)
    {
        $commandClass = get_class($command);

        parent::__construct("The command <$commandClass> hasn't a command handler associated");
    }
}
