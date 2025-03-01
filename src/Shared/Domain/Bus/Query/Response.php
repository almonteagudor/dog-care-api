<?php

declare(strict_types=1);

namespace DogCare\Shared\Domain\Bus\Query;

interface Response
{
    /**
     * @return array<string, mixed>
     */
    public function toPrimitives(): array;
}
