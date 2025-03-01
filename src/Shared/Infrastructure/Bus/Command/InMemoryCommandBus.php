<?php

declare(strict_types=1);

namespace DogCare\Shared\Infrastructure\Bus\Command;

use DogCare\Shared\Domain\Bus\Command\Command;
use DogCare\Shared\Domain\Bus\Command\CommandBus;
use DogCare\Shared\Domain\Bus\Command\CommandHandler;

final readonly class InMemoryCommandBus implements CommandBus
{
    /**
     * @param iterable<CommandHandler> $commandHandlers
     */
    public function __construct(private iterable $commandHandlers)
    {
    }

    public function dispatch(Command $command): void
    {
        foreach ($this->commandHandlers as $handler) {
            if ($handler::class === $command::class . 'Handler') {
                $handler($command);

                return;
            }
        }

        throw new CommandNotRegisteredException($command);
    }
}
