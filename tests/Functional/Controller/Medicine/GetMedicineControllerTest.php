<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller\Medicine;

use App\Tests\Functional\FunctionalTestCase;
use DogCare\Medicine\Domain\Medicine;
use DogCare\Medicine\Domain\MedicineDescription;
use DogCare\Medicine\Domain\MedicineId;
use DogCare\Medicine\Domain\MedicineName;
use Symfony\Component\HttpFoundation\Response;

class GetMedicineControllerTest extends FunctionalTestCase
{
    public function testGetMedicineOkResponse(): void
    {
        $medicine = new Medicine(MedicineId::random(), new MedicineName('name'), new MedicineDescription('description'));

        $this->insert(Medicine::primitiveName(), $medicine->toPrimitives());

        $response = $this->httpGet('get-medicine', ['id' => $medicine->id->value()]);

        $responseData = json_decode($response->getContent(), true);

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertEquals($medicine->id->value(), $responseData[MedicineId::primitiveName()]);
        $this->assertEquals($medicine->name->value(), $responseData[MedicineName::primitiveName()]);
        $this->assertEquals($medicine->description->value(), $responseData[MedicineDescription::primitiveName()]);
    }

    public function testGetMedicineWithRandomIdNotFoundResponse(): void
    {
        $response = $this->httpGet('get-medicine', ['id' => MedicineId::random()->value()]);

        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->deleteAll(Medicine::primitiveName());
    }
}
