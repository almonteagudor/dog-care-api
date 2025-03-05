<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller\Medicine;

use App\Tests\Functional\FunctionalTestCase;
use DogCare\Medicine\Domain\Medicine;
use DogCare\Medicine\Domain\MedicineId;
use DogCare\Medicine\Domain\MedicineName;
use Symfony\Component\HttpFoundation\Response;

class GetMedicinesControllerTest extends FunctionalTestCase
{
    public function testGetMedicines(): void
    {
        $firstMedicine = new Medicine(MedicineId::random(), new MedicineName('first_name'), null);
        $secondMedicine = new Medicine(MedicineId::random(), new MedicineName('second_name'), null);

        $this->insert(Medicine::primitiveName(), $firstMedicine->toPrimitives());
        $this->insert(Medicine::primitiveName(), $secondMedicine->toPrimitives());

        $response = $this->httpGet('get-medicines');

        $responseData = json_decode($response->getContent(), true);

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertIsArray($responseData);
        $this->assertCount(2, $responseData);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->deleteAll(Medicine::primitiveName());
    }
}
