<?php

declare(strict_types=1);

namespace DogCare\Allergy\Application\Find;

use DogCare\Shared\Domain\Bus\Query\Response;

final readonly class AllergiesResponse implements Response
{
    /**
     * @param array<AllergyResponse> $allergyResponses
     */
    public function __construct(private array $allergyResponses)
    {
    }

    public function toPrimitives(): array
    {
        return array_map(fn (AllergyResponse $response) => $response->toPrimitives(), $this->allergyResponses);
    }
}
