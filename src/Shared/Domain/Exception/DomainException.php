<?php

declare(strict_types=1);

namespace DogCare\Shared\Domain\Exception;

abstract class DomainException extends \DomainException
{
    public function __construct()
    {
        parent::__construct($this->errorMessage());
    }

    protected abstract function errorMessage(): string;

    public abstract function errorCode(): string;
}
