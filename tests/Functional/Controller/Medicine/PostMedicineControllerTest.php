<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller\Medicine;

use App\Tests\Functional\FunctionalTestCase;
use DogCare\Medicine\Domain\Medicine;
use DogCare\Medicine\Domain\MedicineDescription;
use DogCare\Medicine\Domain\MedicineId;
use DogCare\Medicine\Domain\MedicineName;
use Symfony\Component\HttpFoundation\Response;

class PostMedicineControllerTest extends FunctionalTestCase
{
    public function testPostMedicineCreatedResponse(): void
    {
        $medicine = new Medicine(MedicineId::random(), new MedicineName('Name'), new MedicineDescription('Description'));

        $response = $this->httpPost(
            'post-medicine',
            ['id' => $medicine->id->value()],
            $medicine->toPrimitives(),
        );

        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());

        $storedMedicine = $this->findById(Medicine::primitiveName(), $medicine->id);

        $this->assertEquals($medicine->id->value(), $storedMedicine[MedicineId::primitiveName()]);
        $this->assertEquals($medicine->name->value(), $storedMedicine[MedicineName::primitiveName()]);
        $this->assertEquals($medicine->description->value(), $storedMedicine[MedicineDescription::primitiveName()]);
    }

    public function testPostMedicineWithoutNameBadRequestResponse(): void
    {
        $medicineData = new Medicine(
            MedicineId::random(),
            new MedicineName('Name'),
            new MedicineDescription('Description'),
        )->toPrimitives();

        unset($medicineData[MedicineName::primitiveName()]);

        $response = $this->httpPost(
            'post-medicine',
            ['id' => $medicineData[MedicineId::primitiveName()]],
            $medicineData,
        );

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function testPostMedicineWithoutDescriptionBadRequestResponse(): void
    {
        $medicineData = new Medicine(
            MedicineId::random(),
            new MedicineName('Name'),
            new MedicineDescription('Description'),
        )->toPrimitives();

        unset($medicineData[MedicineDescription::primitiveName()]);

        $response = $this->httpPost(
            'post-medicine',
            ['id' => $medicineData[MedicineId::primitiveName()]],
            $medicineData,
        );

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function testPostMedicineWithNullNameBadRequestResponse(): void
    {
        $medicineData = new Medicine(
            MedicineId::random(),
            new MedicineName('Name'),
            new MedicineDescription('Description'),
        )->toPrimitives();

        $medicineData[MedicineName::primitiveName()] = null;

        $response = $this->httpPost(
            'post-medicine',
            ['id' => $medicineData[MedicineId::primitiveName()]],
            $medicineData,
        );

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function testPostMedicineWithNullDescriptionOkResponse(): void
    {
        $medicineData = new Medicine(
            MedicineId::random(),
            new MedicineName('Name'),
            new MedicineDescription('Description'),
        )->toPrimitives();

        $medicineData[MedicineDescription::primitiveName()] = null;

        $response = $this->httpPost(
            'post-medicine',
            ['id' => $medicineData[MedicineId::primitiveName()]],
            $medicineData,
        );

        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());

        $storedMedicine = $this->findById(
            Medicine::primitiveName(),
            new MedicineId($medicineData[MedicineId::primitiveName()]),
        );

        $this->assertEquals($medicineData[MedicineId::primitiveName()], $storedMedicine[MedicineId::primitiveName()]);
        $this->assertEquals($medicineData[MedicineName::primitiveName()], $storedMedicine[MedicineName::primitiveName()]);
        $this->assertNull($storedMedicine[MedicineDescription::primitiveName()]);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->deleteAll(Medicine::primitiveName());
    }
}
