<?php

declare(strict_types=1);

namespace DogCare\Medicine\Application\Find;

use DogCare\Medicine\Domain\Medicine;
use DogCare\Medicine\Domain\MedicineDescription;
use DogCare\Medicine\Domain\MedicineId;
use DogCare\Medicine\Domain\MedicineName;
use DogCare\Shared\Domain\Bus\Query\Response;

final readonly class MedicineResponse implements Response
{

    public function __construct(private string $id, private string $name, private ?string $description)
    {
    }

    public static function fromMedicine(Medicine $medicine): self
    {
        return new self(
            $medicine->id->value(),
            $medicine->name->value(),
            $medicine->description?->value(),
        );
    }

    public function toPrimitives(): array
    {
        return [
            MedicineId::primitiveName() => $this->id,
            MedicineName::primitiveName() => $this->name,
            MedicineDescription::primitiveName() => $this->description,
        ];
    }
}
