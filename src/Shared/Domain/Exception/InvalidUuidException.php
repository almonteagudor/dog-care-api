<?php

declare(strict_types=1);

namespace DogCare\Shared\Domain\Exception;

final class InvalidUuidException extends DomainException
{
    public function __construct(private readonly string $value)
    {
        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'invalid_uuid';
    }

    protected function errorMessage(): string
    {
        return sprintf("The value '%s' is not a valid UUID", $this->value);
    }
}
