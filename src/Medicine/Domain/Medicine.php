<?php

declare(strict_types=1);

namespace DogCare\Medicine\Domain;

use DogCare\Shared\Domain\Aggregate\AggregateRoot;
use DogCare\Shared\Domain\ValueObject\CreatedAt;
use DogCare\Shared\Domain\ValueObject\DeletedAt;
use DogCare\Shared\Domain\ValueObject\UpdatedAt;

final class Medicine extends AggregateRoot
{
    public static function create(
        string $id,
        string $name,
        ?string $description,
    ): self {
        return new self(
            new MedicineId($id),
            new MedicineName($name),
            $description ? new MedicineDescription($description) : null,
        );
    }

    public function __construct(
        MedicineId $id,
        private(set) MedicineName $name,
        private(set) ?MedicineDescription $description,
        private(set) readonly CreatedAt $createdAt = new CreatedAt(),
        private(set) ?UpdatedAt $updatedAt = null,
        private(set) ?DeletedAt $deletedAt = null,
    ) {
        parent::__construct($id);
    }

    public static function fromPrimitives(array $data): Medicine
    {
        return new Medicine(
            new MedicineId($data[MedicineId::primitiveName()]),
            new MedicineName($data[MedicineName::primitiveName()]),
            isset($data[MedicineDescription::primitiveName()])
                ? new MedicineDescription($data[MedicineDescription::primitiveName()])
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
        return 'medicine';
    }

    public function toPrimitives(): array
    {
        return [
            MedicineId::primitiveName() => $this->id->value(),
            MedicineName::primitiveName() => $this->name->value(),
            MedicineDescription::primitiveName() => $this->description?->value(),
            CreatedAt::primitiveName() => $this->createdAt->value(),
            UpdatedAt::primitiveName() => $this->updatedAt?->value(),
            DeletedAt::primitiveName() => $this->deletedAt?->value(),
        ];
    }

    public function updateName(MedicineName $name): void
    {
        if (!$this->name->equals($name)) {
            $this->name = $name;
            $this->updatedAt = new UpdatedAt();
        }
    }

    public function updateDescription(?MedicineDescription $description): void
    {
        if ($this->description?->equals($description) || $this->description === $description) {
            return;
        }

        $this->description = $description;
        $this->updatedAt = new UpdatedAt();
    }

    public function save(MedicineRepository $repository): void
    {
        $repository->save($this);
    }

    public function delete(MedicineRepository $repository): void
    {
        $this->deletedAt = new DeletedAt();
        $repository->save($this);
    }
}
