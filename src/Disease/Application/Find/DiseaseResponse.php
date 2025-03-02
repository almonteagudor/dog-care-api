<?php

declare(strict_types=1);

namespace DogCare\Disease\Application\Find;

use DogCare\Disease\Domain\Disease;
use DogCare\Disease\Domain\DiseaseDescription;
use DogCare\Disease\Domain\DiseaseId;
use DogCare\Disease\Domain\DiseaseName;
use DogCare\Shared\Domain\Bus\Query\Response;

final readonly class DiseaseResponse implements Response
{

    public function __construct(private string $id, private string $name, private ?string $description)
    {
    }

    public static function fromDisease(Disease $disease): self
    {
        return new self(
            $disease->id->value(),
            $disease->name->value(),
            $disease->description?->value(),
        );
    }

    public function toPrimitives(): array
    {
        return [
            DiseaseId::primitiveName() => $this->id,
            DiseaseName::primitiveName() => $this->name,
            DiseaseDescription::primitiveName() => $this->description,
        ];
    }
}
