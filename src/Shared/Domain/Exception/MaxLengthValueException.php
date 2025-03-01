<?php

declare(strict_types=1);

namespace DogCare\Shared\Domain\Exception;

final class MaxLengthValueException extends DomainException
{
    public function __construct(
        private readonly string $value,
        private readonly string $name,
        private readonly int $maxLength,
    ) {
        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'max_length_value';
    }

    protected function errorMessage(): string
    {
        return sprintf(
            "The length of value '%s' for '%s' is not valid. Max length is %d",
            $this->value,
            $this->name,
            $this->maxLength,
        );
    }
}
