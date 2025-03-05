<?php

declare(strict_types=1);

namespace DogCare\Medicine\Application\Find;

use DogCare\Shared\Domain\Bus\Query\Response;

final readonly class MedicinesResponse implements Response
{
    /**
     * @param array<MedicineResponse> $medicineResponses
     */
    public function __construct(private array $medicineResponses)
    {
    }

    public function toPrimitives(): array
    {
        return array_map(fn (MedicineResponse $response) => $response->toPrimitives(), $this->medicineResponses);
    }
}
