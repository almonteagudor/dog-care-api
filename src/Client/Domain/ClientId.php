<?php

declare(strict_types=1);

namespace DogCare\Client\Domain;

use DogCare\Shared\Domain\ValueObject\Uuid;

final readonly class ClientId extends Uuid
{
    public static function primitiveName(): string
    {
        return 'client_id';
    }
}
