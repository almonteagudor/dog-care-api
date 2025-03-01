<?php

declare(strict_types=1);

namespace DogCare\Shared\Domain\ValueObject;

use DateTimeImmutable;
use DogCare\Shared\Domain\Exception\InvalidDateTimeException;

abstract readonly class DateTimeValueObject extends StringValueObject
{
    private const string FORMAT = 'd-m-Y H:i:s';

    public function __construct(string $value = 'now')
    {
        if ($value === 'now') {
            $value = new DateTimeImmutable()->format(self::FORMAT);
        }

        parent::__construct($value);
    }

    protected function ensureIsValid(string $value): void
    {
        if ($value !== 'now' && !DateTimeImmutable::createFromFormat(self::FORMAT, $value)) {
            throw new InvalidDateTimeException($value, self::FORMAT);
        }
    }
}
