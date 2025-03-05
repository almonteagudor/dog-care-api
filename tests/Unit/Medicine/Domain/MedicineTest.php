<?php

declare(strict_types=1);

namespace App\Tests\Unit\Medicine\Domain;

use DogCare\Medicine\Domain\Medicine;
use DogCare\Medicine\Domain\MedicineDescription;
use DogCare\Medicine\Domain\MedicineId;
use DogCare\Medicine\Domain\MedicineName;
use DogCare\Medicine\Infrastructure\MedicineDoctrineRepository;
use DogCare\Shared\Domain\ValueObject\CreatedAt;
use PHPUnit\Framework\TestCase;

final class MedicineTest extends TestCase
{
    public function testMedicineCreation(): void
    {
        $id = MedicineId::random();
        $name = new MedicineName('Name');
        $description = new MedicineDescription('Description');
        $createdAt = new CreatedAt();

        $medicine = new Medicine($id, $name, $description, $createdAt);

        $this->assertEquals($id->value(), $medicine->id->value());
        $this->assertEquals($name->value(), $medicine->name->value());
        $this->assertEquals($description->value(), $medicine->description->value());
        $this->assertEquals($createdAt->value(), $medicine->createdAt->value());
    }

    public function testToPrimitives(): void
    {
        $id = MedicineId::random();
        $name = new MedicineName('Name');
        $description = new MedicineDescription('Description');
        $createdAt = new CreatedAt();

        $medicine = new Medicine($id, $name, $description, $createdAt);
        $primitives = $medicine->toPrimitives();

        $this->assertEquals($id->value(), $primitives[MedicineId::primitiveName()]);
        $this->assertEquals($name->value(), $primitives[MedicineName::primitiveName()]);
        $this->assertEquals($description->value(), $primitives[MedicineDescription::primitiveName()]);
        $this->assertEquals($createdAt->value(), $primitives[CreatedAt::primitiveName()]);
    }

    public function testFromPrimitives(): void
    {
        $data = [
            MedicineId::primitiveName() => MedicineId::random()->value(),
            MedicineName::primitiveName() => 'Name',
            MedicineDescription::primitiveName() => 'Description',
            CreatedAt::primitiveName() => new CreatedAt()->value(),
        ];

        $medicine = Medicine::fromPrimitives($data);

        $this->assertEquals($data[MedicineId::primitiveName()], $medicine->id->value());
        $this->assertEquals($data[MedicineName::primitiveName()], $medicine->name->value());
        $this->assertEquals($data[MedicineDescription::primitiveName()], $medicine->description->value());
        $this->assertEquals($data[CreatedAt::primitiveName()], $medicine->createdAt->value());
    }

    public function testUpdateName(): void
    {
        $medicine = new Medicine(MedicineId::random(), new MedicineName('Name'), null, new CreatedAt());
        $oldUpdatedAt = $medicine->updatedAt;

        $medicine->updateName(new MedicineName('Name Updated'));

        $this->assertEquals('Name Updated', $medicine->name->value());
        $this->assertNotEquals($oldUpdatedAt, $medicine->updatedAt);
    }

    public function testUpdateNullDescriptionToNullDescription(): void
    {
        $medicine = new Medicine(
            MedicineId::random(),
            new MedicineName('Name'),
            null,
            new CreatedAt(),
        );

        $medicine->updateDescription(null);

        $this->assertNull($medicine->description);
        $this->assertNull($medicine->updatedAt);
    }

    public function testUpdateNullDescriptionToDescription(): void
    {
        $medicine = new Medicine(
            MedicineId::random(),
            new MedicineName('Name'),
            null,
            new CreatedAt(),
        );

        $medicine->updateDescription(new MedicineDescription('Description'));

        $this->assertEquals('Description', $medicine->description->value());
        $this->assertNotNull($medicine->updatedAt);
    }

    public function testUpdateDescriptionToNullDescription(): void
    {
        $medicine = new Medicine(
            MedicineId::random(),
            new MedicineName('Name'),
            new MedicineDescription('Description'),
            new CreatedAt(),
        );

        $medicine->updateDescription(null);

        $this->assertNull($medicine->description);
        $this->assertNotNull($medicine->updatedAt);
    }

    public function testUpdateDescriptionToSameDescription(): void
    {
        $medicine = new Medicine(
            MedicineId::random(),
            new MedicineName('Name'),
            new MedicineDescription('Description'),
            new CreatedAt(),
        );

        $medicine->updateDescription(new MedicineDescription('Description'));

        $this->assertEquals('Description', $medicine->description->value());
        $this->assertNull($medicine->updatedAt);
    }

    public function testUpdateDescriptionToDescription(): void
    {
        $medicine = new Medicine(
            MedicineId::random(),
            new MedicineName('Name'),
            new MedicineDescription('Description'),
            new CreatedAt(),
        );

        $medicine->updateDescription(new MedicineDescription('Description Updated'));

        $this->assertEquals('Description Updated', $medicine->description->value());
        $this->assertNotNull($medicine->updatedAt);
    }

    public function testDelete(): void
    {
        $repository = $this->createMock(MedicineDoctrineRepository::class);
        $repository->expects($this->once())->method('save');

        $medicine = new Medicine(MedicineId::random(), new MedicineName('Rabies'), null, new CreatedAt());
        $medicine->delete($repository);

        $this->assertNotNull($medicine->deletedAt);
    }
}
