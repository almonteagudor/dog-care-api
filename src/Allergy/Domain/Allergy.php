<?php

declare(strict_types=1);

namespace DogCare\Allergy\Domain;

use DogCare\Shared\Domain\Aggregate\AggregateRoot;
use DogCare\Shared\Domain\ValueObject\CreatedAt;
use DogCare\Shared\Domain\ValueObject\DeletedAt;
use DogCare\Shared\Domain\ValueObject\UpdatedAt;

final class Allergy extends AggregateRoot
{
    public static function create(
        string $id,
        string $name,
        ?string $description,
    ): self {
        return new self(
            new AllergyId($id),
            new AllergyName($name),
            $description ? new AllergyDescription($description) : null,
        );
    }

    public function __construct(
        AllergyId $id,
        private(set) AllergyName $name,
        private(set) ?AllergyDescription $description,
        private(set) readonly CreatedAt $createdAt = new CreatedAt(),
        private(set) ?UpdatedAt $updatedAt = null,
        private(set) ?DeletedAt $deletedAt = null,
    ) {
        parent::__construct($id);
    }

    public static function fromPrimitives(array $data): Allergy
    {
        return new Allergy(
            new AllergyId($data[AllergyId::primitiveName()]),
            new AllergyName($data[AllergyName::primitiveName()]),
            isset($data[AllergyDescription::primitiveName()])
                ? new AllergyDescription($data[AllergyDescription::primitiveName()])
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
        return 'allergy';
    }

    public function toPrimitives(): array
    {
        return [
            AllergyId::primitiveName() => $this->id->value(),
            AllergyName::primitiveName() => $this->name->value(),
            AllergyDescription::primitiveName() => $this->description?->value(),
            CreatedAt::primitiveName() => $this->createdAt->value(),
            UpdatedAt::primitiveName() => $this->updatedAt?->value(),
            DeletedAt::primitiveName() => $this->deletedAt?->value(),
        ];
    }

    public function updateName(AllergyName $name): void
    {
        if (!$this->name->equals($name)) {
            $this->name = $name;
            $this->updatedAt = new UpdatedAt();
        }
    }

    public function updateDescription(?AllergyDescription $description): void
    {
        if ($this->description?->equals($description) || $this->description === $description) {
            return;
        }

        $this->description = $description;
        $this->updatedAt = new UpdatedAt();
    }

    public function save(AllergyRepository $repository): void
    {
        $repository->save($this);
    }

    public function delete(AllergyRepository $repository): void
    {
        $this->deletedAt = new DeletedAt();
        $repository->save($this);
    }
}
