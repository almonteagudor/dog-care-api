<?php

declare(strict_types=1);

namespace DogCare\Allergy\Application\Find;

use DogCare\Allergy\Domain\Allergy;
use DogCare\Allergy\Domain\AllergyDescription;
use DogCare\Allergy\Domain\AllergyId;
use DogCare\Allergy\Domain\AllergyName;
use DogCare\Shared\Domain\Bus\Query\Response;

final readonly class AllergyResponse implements Response
{

    public function __construct(private string $id, private string $name, private ?string $description)
    {
    }

    public static function fromAllergy(Allergy $allergy): self
    {
        return new self(
            $allergy->id->value(),
            $allergy->name->value(),
            $allergy->description?->value(),
        );
    }

    public function toPrimitives(): array
    {
        return [
            AllergyId::primitiveName() => $this->id,
            AllergyName::primitiveName() => $this->name,
            AllergyDescription::primitiveName() => $this->description,
        ];
    }
}
