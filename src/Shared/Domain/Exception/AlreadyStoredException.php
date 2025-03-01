<?php

declare(strict_types=1);

namespace DogCare\Shared\Domain\Exception;

final class AlreadyStoredException extends DomainException
{
    public function __construct(private readonly string $name, private readonly string $id)
    {
        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'already_stored';
    }

    protected function errorMessage(): string
    {
        return sprintf("The '%s' with id '%s' is already stored", $this->name, $this->id);
    }
}
