<?php

declare(strict_types=1);

namespace App\Tests\Unit\Allergy\Domain;

use DogCare\Allergy\Domain\Allergy;
use DogCare\Allergy\Domain\AllergyDescription;
use DogCare\Allergy\Domain\AllergyId;
use DogCare\Allergy\Domain\AllergyName;
use DogCare\Allergy\Infrastructure\AllergyDoctrineRepository;
use DogCare\Shared\Domain\ValueObject\CreatedAt;
use PHPUnit\Framework\TestCase;

final class AllergyTest extends TestCase
{
    public function testAllergyCreation(): void
    {
        $id = AllergyId::random();
        $name = new AllergyName('Name');
        $description = new AllergyDescription('Description');
        $createdAt = new CreatedAt();

        $disease = new Allergy($id, $name, $description, $createdAt);

        $this->assertEquals($id->value(), $disease->id->value());
        $this->assertEquals($name->value(), $disease->name->value());
        $this->assertEquals($description->value(), $disease->description->value());
        $this->assertEquals($createdAt->value(), $disease->createdAt->value());
    }

    public function testToPrimitives(): void
    {
        $id = AllergyId::random();
        $name = new AllergyName('Name');
        $description = new AllergyDescription('Description');
        $createdAt = new CreatedAt();

        $disease = new Allergy($id, $name, $description, $createdAt);
        $primitives = $disease->toPrimitives();

        $this->assertEquals($id->value(), $primitives[AllergyId::primitiveName()]);
        $this->assertEquals($name->value(), $primitives[AllergyName::primitiveName()]);
        $this->assertEquals($description->value(), $primitives[AllergyDescription::primitiveName()]);
        $this->assertEquals($createdAt->value(), $primitives[CreatedAt::primitiveName()]);
    }

    public function testFromPrimitives(): void
    {
        $data = [
            AllergyId::primitiveName() => AllergyId::random()->value(),
            AllergyName::primitiveName() => 'Name',
            AllergyDescription::primitiveName() => 'Description',
            CreatedAt::primitiveName() => new CreatedAt()->value(),
        ];

        $disease = Allergy::fromPrimitives($data);

        $this->assertEquals($data[AllergyId::primitiveName()], $disease->id->value());
        $this->assertEquals($data[AllergyName::primitiveName()], $disease->name->value());
        $this->assertEquals($data[AllergyDescription::primitiveName()], $disease->description->value());
        $this->assertEquals($data[CreatedAt::primitiveName()], $disease->createdAt->value());
    }

    public function testUpdateName(): void
    {
        $disease = new Allergy(AllergyId::random(), new AllergyName('Name'), null, new CreatedAt());
        $oldUpdatedAt = $disease->updatedAt;

        $disease->updateName(new AllergyName('Name Updated'));

        $this->assertEquals('Name Updated', $disease->name->value());
        $this->assertNotEquals($oldUpdatedAt, $disease->updatedAt);
    }

    public function testUpdateNullDescriptionToNullDescription(): void
    {
        $disease = new Allergy(
            AllergyId::random(),
            new AllergyName('Name'),
            null,
            new CreatedAt(),
        );

        $disease->updateDescription(null);

        $this->assertNull($disease->description);
        $this->assertNull($disease->updatedAt);
    }

    public function testUpdateNullDescriptionToDescription(): void
    {
        $disease = new Allergy(
            AllergyId::random(),
            new AllergyName('Name'),
            null,
            new CreatedAt(),
        );

        $disease->updateDescription(new AllergyDescription('Description'));

        $this->assertEquals('Description', $disease->description->value());
        $this->assertNotNull($disease->updatedAt);
    }

    public function testUpdateDescriptionToNullDescription(): void
    {
        $disease = new Allergy(
            AllergyId::random(),
            new AllergyName('Name'),
            new AllergyDescription('Description'),
            new CreatedAt(),
        );

        $disease->updateDescription(null);

        $this->assertNull($disease->description);
        $this->assertNotNull($disease->updatedAt);
    }

    public function testUpdateDescriptionToSameDescription(): void
    {
        $disease = new Allergy(
            AllergyId::random(),
            new AllergyName('Name'),
            new AllergyDescription('Description'),
            new CreatedAt(),
        );

        $disease->updateDescription(new AllergyDescription('Description'));

        $this->assertEquals('Description', $disease->description->value());
        $this->assertNull($disease->updatedAt);
    }

    public function testUpdateDescriptionToDescription(): void
    {
        $disease = new Allergy(
            AllergyId::random(),
            new AllergyName('Name'),
            new AllergyDescription('Description'),
            new CreatedAt(),
        );

        $disease->updateDescription(new AllergyDescription('Description Updated'));

        $this->assertEquals('Description Updated', $disease->description->value());
        $this->assertNotNull($disease->updatedAt);
    }

    public function testDelete(): void
    {
        $repository = $this->createMock(AllergyDoctrineRepository::class);
        $repository->expects($this->once())->method('save');

        $disease = new Allergy(AllergyId::random(), new AllergyName('Rabies'), null, new CreatedAt());
        $disease->delete($repository);

        $this->assertNotNull($disease->deletedAt);
    }
}
