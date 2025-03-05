<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller\Medicine;

use App\Tests\Functional\FunctionalTestCase;
use Doctrine\DBAL\Exception;
use DogCare\Medicine\Domain\Medicine;
use DogCare\Medicine\Domain\MedicineDescription;
use DogCare\Medicine\Domain\MedicineId;
use DogCare\Medicine\Domain\MedicineName;
use DogCare\Shared\Domain\ValueObject\DeletedAt;
use Symfony\Component\HttpFoundation\Response;

class DeleteMedicineControllerTest extends FunctionalTestCase
{
    /**
     * @throws Exception
     */
    public function testDeleteMedicineNoContentResponse(): void
    {
        $medicineData = new Medicine(
            MedicineId::random(),
            new MedicineName('Name'),
            new MedicineDescription('Description'),
        )->toPrimitives();

        $this->insert(Medicine::primitiveName(), $medicineData);

        $response = $this->httpDelete('delete-medicine', ['id' => $medicineData[MedicineId::primitiveName()]]);

        $this->assertEquals(Response::HTTP_NO_CONTENT, $response->getStatusCode());

        $storedMedicine = $this->findById(Medicine::primitiveName(), new MedicineId($medicineData[MedicineId::primitiveName()]));

        $this->assertNotNull($storedMedicine[DeletedAt::primitiveName()]);
    }

    public function testDeleteMedicineWithRandomIdNotFoundResponse(): void
    {
        $response = $this->httpDelete('put-medicine', ['id' => MedicineId::random()->value()]);

        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->deleteAll(Medicine::primitiveName());
    }
}
