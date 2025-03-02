<?php

declare(strict_types=1);

namespace DogCare\Disease\Domain;

use DogCare\Shared\Domain\Aggregate\AggregateRoot;
use DogCare\Shared\Domain\ValueObject\CreatedAt;
use DogCare\Shared\Domain\ValueObject\DeletedAt;
use DogCare\Shared\Domain\ValueObject\UpdatedAt;

final class Disease extends AggregateRoot
{
    public function __construct(
        private readonly DiseaseId $id,
        private DiseaseName $name,
        private ?DiseaseDescription $description,
        private readonly CreatedAt $createdAt = new CreatedAt(),
        private ?UpdatedAt $updatedAt = null,
        private ?DeletedAt $deletedAt = null,
    ) {
    }

    public static function fromPrimitives(array $data): Disease
    {
        return new Disease(
            new DiseaseId($data[DiseaseId::primitiveName()]),
            new DiseaseName($data[DiseaseName::primitiveName()]),
            isset($data[DiseaseDescription::primitiveName()])
                ? new DiseaseDescription($data[DiseaseDescription::primitiveName()])
                : null,
            new CreatedAt($data[CreatedAt::primitiveName()]),
            isset($data[UpdatedAt::primitiveName()])
                ? new UpdatedAt($data[UpdatedAt::primitiveName()])
                : null,
            isset($data[DeletedAt::primitiveName()])
                ? new DeletedAt($data[DeletedAt::primitiveName()])
                : null,
        );
    }

    public static function primitiveName(): string
    {
        return 'disease';
    }

    public function id(): DiseaseId
    {
        return $this->id;
    }

    public function name(): DiseaseName
    {
        return $this->name;
    }

    public function updateName(DiseaseName $name): void
    {
        if (!$this->name->equals($name)) {
            $this->name = $name;
            $this->updatedAt = new UpdatedAt();
        }
    }

    public function description(): ?DiseaseDescription
    {
        return $this->description;
    }

    public function updateDescription(?DiseaseDescription $description): void
    {
        if (!$this->description->equals($description)) {
            $this->description = $description;
            $this->updatedAt = new UpdatedAt();
        }
    }

    public function createdAt(): CreatedAt
    {
        return $this->createdAt;
    }

    public function updatedAt(): ?UpdatedAt
    {
        return $this->updatedAt;
    }

    public function deletedAt(): ?DeletedAt
    {
        return $this->deletedAt;
    }

    public function delete(): void
    {
        $this->deletedAt = new DeletedAt();
    }

    public function toPrimitives(): array
    {
        return [
            DiseaseId::primitiveName() => $this->id->value(),
            DiseaseName::primitiveName() => $this->name->value(),
            DiseaseDescription::primitiveName() => $this->description?->value(),
            CreatedAt::primitiveName() => $this->createdAt->value(),
            UpdatedAt::primitiveName() => $this->updatedAt?->value(),
            DeletedAt::primitiveName() => $this->deletedAt?->value(),
        ];
    }
}
