<?php

declare(strict_types=1);

namespace DogCare\Disease\Application\Find;

use DogCare\Shared\Domain\Bus\Query\Response;

final readonly class DiseasesResponse implements Response
{
    /**
     * @param array<DiseaseResponse> $diseaseResponses
     */
    public function __construct(private array $diseaseResponses)
    {
    }

    public function toPrimitives(): array
    {
        return array_map(fn (DiseaseResponse $response) => $response->toPrimitives(), $this->diseaseResponses);
    }
}
