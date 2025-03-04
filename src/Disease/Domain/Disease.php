<?php

declare(strict_types=1);

namespace DogCare\Disease\Domain;

use DogCare\Disease\Infrastructure\DiseaseDoctrineRepository;
use DogCare\Shared\Domain\Aggregate\AggregateRoot;
use DogCare\Shared\Domain\ValueObject\CreatedAt;
use DogCare\Shared\Domain\ValueObject\DeletedAt;
use DogCare\Shared\Domain\ValueObject\UpdatedAt;

final class Disease extends AggregateRoot
{
    public static function create(
        string $id,
        string $name,
        ?string $description,
    ): self {
        return new self(
            new DiseaseId($id),
            new DiseaseName($name),
            $description ? new DiseaseDescription($description) : null,
        );
    }

    public function __construct(
        DiseaseId $id,
        private(set) DiseaseName $name,
        private(set) ?DiseaseDescription $description,
        private(set) readonly CreatedAt $createdAt = new CreatedAt(),
        private(set) ?UpdatedAt $updatedAt = null,
        private(set) ?DeletedAt $deletedAt = null,
    ) {
        parent::__construct($id);
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

    public function updateName(DiseaseName $name): void
    {
        if (!$this->name->equals($name)) {
            $this->name = $name;
            $this->updatedAt = new UpdatedAt();
        }
    }

    public function updateDescription(?DiseaseDescription $description): void
    {
        if ($this->description?->equals($description) || $this->description === $description) {
            return;
        }

        $this->description = $description;
        $this->updatedAt = new UpdatedAt();
    }

    public function save(DiseaseRepository $repository): void
    {
        $repository->save($this);
    }

    public function delete(DiseaseRepository $repository): void
    {
        $this->deletedAt = new DeletedAt();
        $repository->save($this);
    }
}
