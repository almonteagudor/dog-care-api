<?php

declare(strict_types=1);

namespace DogCare\Shared\Domain\Exception;

final class InvalidDateTimeException extends DomainException
{
    public function __construct(private readonly string $value, private readonly string $format)
    {
        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'invalid_datetime';
    }

    protected function errorMessage(): string
    {
        return sprintf("The value '%s' is not a valid DateTime. Valid format is %s", $this->value, $this->format);
    }
}
