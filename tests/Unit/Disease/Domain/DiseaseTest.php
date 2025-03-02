<?php

declare(strict_types=1);

namespace App\Tests\Unit\Disease\Domain;

use DogCare\Disease\Domain\Disease;
use DogCare\Disease\Domain\DiseaseDescription;
use DogCare\Disease\Domain\DiseaseId;
use DogCare\Disease\Domain\DiseaseName;
use DogCare\Disease\Infrastructure\DiseaseDoctrineRepository;
use DogCare\Shared\Domain\ValueObject\CreatedAt;
use PHPUnit\Framework\TestCase;

final class DiseaseTest extends TestCase
{
    public function testDiseaseCreation(): void
    {
        $id = DiseaseId::random();
        $name = new DiseaseName('Name');
        $description = new DiseaseDescription('Description');
        $createdAt = new CreatedAt();

        $disease = new Disease($id, $name, $description, $createdAt);

        $this->assertEquals($id->value(), $disease->id->value());
        $this->assertEquals($name->value(), $disease->name->value());
        $this->assertEquals($description->value(), $disease->description->value());
        $this->assertEquals($createdAt->value(), $disease->createdAt->value());
    }

    public function testToPrimitives(): void
    {
        $id = DiseaseId::random();
        $name = new DiseaseName('Name');
        $description = new DiseaseDescription('Description');
        $createdAt = new CreatedAt();

        $disease = new Disease($id, $name, $description, $createdAt);
        $primitives = $disease->toPrimitives();

        $this->assertEquals($id->value(), $primitives[DiseaseId::primitiveName()]);
        $this->assertEquals($name->value(), $primitives[DiseaseName::primitiveName()]);
        $this->assertEquals($description->value(), $primitives[DiseaseDescription::primitiveName()]);
        $this->assertEquals($createdAt->value(), $primitives[CreatedAt::primitiveName()]);
    }

    public function testFromPrimitives(): void
    {
        $data = [
            DiseaseId::primitiveName() => DiseaseId::random()->value(),
            DiseaseName::primitiveName() => 'Name',
            DiseaseDescription::primitiveName() => 'Description',
            CreatedAt::primitiveName() => new CreatedAt()->value(),
        ];

        $disease = Disease::fromPrimitives($data);

        $this->assertEquals($data[DiseaseId::primitiveName()], $disease->id->value());
        $this->assertEquals($data[DiseaseName::primitiveName()], $disease->name->value());
        $this->assertEquals($data[DiseaseDescription::primitiveName()], $disease->description->value());
        $this->assertEquals($data[CreatedAt::primitiveName()], $disease->createdAt->value());
    }

    public function testUpdateName(): void
    {
        $disease = new Disease(DiseaseId::random(), new DiseaseName('Name'), null, new CreatedAt());
        $oldUpdatedAt = $disease->updatedAt;

        $disease->updateName(new DiseaseName('Name Updated'));

        $this->assertEquals('Name Updated', $disease->name->value());
        $this->assertNotEquals($oldUpdatedAt, $disease->updatedAt);
    }

    public function testUpdateNullDescriptionToNullDescription(): void
    {
        $disease = new Disease(
            DiseaseId::random(),
            new DiseaseName('Name'),
            null,
            new CreatedAt(),
        );

        $disease->updateDescription(null);

        $this->assertNull($disease->description);
        $this->assertNull($disease->updatedAt);
    }

    public function testUpdateNullDescriptionToDescription(): void
    {
        $disease = new Disease(
            DiseaseId::random(),
            new DiseaseName('Name'),
            null,
            new CreatedAt(),
        );

        $disease->updateDescription(new DiseaseDescription('Description'));

        $this->assertEquals('Description', $disease->description->value());
        $this->assertNotNull($disease->updatedAt);
    }

    public function testUpdateDescriptionToNullDescription(): void
    {
        $disease = new Disease(
            DiseaseId::random(),
            new DiseaseName('Name'),
            new DiseaseDescription('Description'),
            new CreatedAt(),
        );

        $disease->updateDescription(null);

        $this->assertNull($disease->description);
        $this->assertNotNull($disease->updatedAt);
    }

    public function testUpdateDescriptionToSameDescription(): void
    {
        $disease = new Disease(
            DiseaseId::random(),
            new DiseaseName('Name'),
            new DiseaseDescription('Description'),
            new CreatedAt(),
        );

        $disease->updateDescription(new DiseaseDescription('Description'));

        $this->assertEquals('Description', $disease->description->value());
        $this->assertNull($disease->updatedAt);
    }

    public function testUpdateDescriptionToDescription(): void
    {
        $disease = new Disease(
            DiseaseId::random(),
            new DiseaseName('Name'),
            new DiseaseDescription('Description'),
            new CreatedAt(),
        );

        $disease->updateDescription(new DiseaseDescription('Description Updated'));

        $this->assertEquals('Description Updated', $disease->description->value());
        $this->assertNotNull($disease->updatedAt);
    }

    public function testDelete(): void
    {
        $repository = $this->createMock(DiseaseDoctrineRepository::class);
        $repository->expects($this->once())->method('save');

        $disease = new Disease(DiseaseId::random(), new DiseaseName('Rabies'), null, new CreatedAt());
        $disease->delete($repository);

        $this->assertNotNull($disease->deletedAt);
    }
}
