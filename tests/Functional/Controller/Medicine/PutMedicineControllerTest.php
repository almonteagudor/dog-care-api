<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller\Medicine;

use App\Tests\Functional\FunctionalTestCase;
use Doctrine\DBAL\Exception;
use DogCare\Medicine\Domain\Medicine;
use DogCare\Medicine\Domain\MedicineDescription;
use DogCare\Medicine\Domain\MedicineId;
use DogCare\Medicine\Domain\MedicineName;
use DogCare\Shared\Domain\ValueObject\UpdatedAt;
use Symfony\Component\HttpFoundation\Response;

class PutMedicineControllerTest extends FunctionalTestCase
{
    /**
     * @throws Exception
     */
    public function testPutMedicineUpdateNameOkResponse(): void
    {
        $medicineData = new Medicine(
            MedicineId::random(),
            new MedicineName('Name'),
            new MedicineDescription('Description'),
        )->toPrimitives();

        $this->insert(Medicine::primitiveName(), $medicineData);

        $medicineData[MedicineName::primitiveName()] = 'Name Updated';

        $response = $this->httpPut(
            'put-medicine',
            ['id' => $medicineData[MedicineId::primitiveName()]],
            $medicineData,
        );

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());

        $storedMedicine = $this->findById(Medicine::primitiveName(), new MedicineId($medicineData[MedicineId::primitiveName()]));

        $this->assertEquals($medicineData[MedicineName::primitiveName()], $storedMedicine[MedicineName::primitiveName()]);
        $this->assertNotNull($storedMedicine[UpdatedAt::primitiveName()]);
    }

    /**
     * @throws Exception
     */
    public function testPutMedicineUpdateDescriptionOkResponse(): void
    {
        $medicineData = new Medicine(
            MedicineId::random(),
            new MedicineName('Name'),
            new MedicineDescription('Description'),
        )->toPrimitives();

        $this->insert(Medicine::primitiveName(), $medicineData);

        $medicineData[MedicineDescription::primitiveName()] = 'Description Updated';

        $response = $this->httpPut(
            'put-medicine',
            ['id' => $medicineData[MedicineId::primitiveName()]],
            $medicineData,
        );

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());

        $storedMedicine = $this->findById(Medicine::primitiveName(), new MedicineId($medicineData[MedicineId::primitiveName()]));

        $this->assertEquals(
            $medicineData[MedicineDescription::primitiveName()],
            $storedMedicine[MedicineDescription::primitiveName()],
        );
        $this->assertNotNull($storedMedicine[UpdatedAt::primitiveName()]);
    }

    public function testPutMedicineUpdateWithoutNameBadRequestResponse(): void
    {
        $medicineData = new Medicine(
            MedicineId::random(),
            new MedicineName('Name'),
            new MedicineDescription('Description'),
        )->toPrimitives();

        $this->insert(Medicine::primitiveName(), $medicineData);

        unset($medicineData[MedicineName::primitiveName()]);

        $response = $this->httpPut(
            'put-medicine',
            ['id' => $medicineData[MedicineId::primitiveName()]],
            $medicineData,
        );

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function testPutMedicineUpdateWithoutDescriptionBadRequestResponse(): void
    {
        $medicineData = new Medicine(
            MedicineId::random(),
            new MedicineName('Name'),
            new MedicineDescription('Description'),
        )->toPrimitives();

        $this->insert(Medicine::primitiveName(), $medicineData);

        unset($medicineData[MedicineDescription::primitiveName()]);

        $response = $this->httpPut(
            'put-medicine',
            ['id' => $medicineData[MedicineId::primitiveName()]],
            $medicineData,
        );

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    /**
     * @throws Exception
     */
    public function testPutMedicineUpdateDescriptionWithNullOkResponse(): void
    {
        $medicineData = new Medicine(
            MedicineId::random(),
            new MedicineName('Name'),
            new MedicineDescription('Description'),
        )->toPrimitives();

        $this->insert(Medicine::primitiveName(), $medicineData);

        $medicineData[MedicineDescription::primitiveName()] = null;

        $response = $this->httpPut(
            'put-medicine',
            ['id' => $medicineData[MedicineId::primitiveName()]],
            $medicineData,
        );

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());

        $storedMedicine = $this->findById(Medicine::primitiveName(), new MedicineId($medicineData[MedicineId::primitiveName()]));

        $this->assertNull($storedMedicine[MedicineDescription::primitiveName()]);
        $this->assertNotNull($storedMedicine[UpdatedAt::primitiveName()]);
    }

    public function testPutMedicineWithRandomIdNotFoundResponse(): void
    {
        $medicineData = new Medicine(
            MedicineId::random(),
            new MedicineName('Name'),
            new MedicineDescription('Description'),
        )->toPrimitives();

        $response = $this->httpPut(
            'put-medicine',
            ['id' => $medicineData[MedicineId::primitiveName()]],
            $medicineData,
        );

        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->deleteAll(Medicine::primitiveName());
    }
}
