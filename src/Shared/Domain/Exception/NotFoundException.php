<?php

declare(strict_types=1);

namespace DogCare\Shared\Domain\Exception;

final class NotFoundException extends DomainException
{
    public function __construct(private readonly string $name, private readonly string $value)
    {
        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'not_found';
    }

    protected function errorMessage(): string
    {
        return sprintf("Not found '%s' with id '%s'", $this->name, $this->value);
    }
}
