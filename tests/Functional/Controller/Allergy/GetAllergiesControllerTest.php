<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller\Allergy;

use App\Tests\Functional\FunctionalTestCase;
use DogCare\Allergy\Domain\Allergy;
use DogCare\Allergy\Domain\AllergyId;
use DogCare\Allergy\Domain\AllergyName;
use Symfony\Component\HttpFoundation\Response;

class GetAllergiesControllerTest extends FunctionalTestCase
{
    public function testGetAllergies(): void
    {
        $firstAllergy = new Allergy(AllergyId::random(), new AllergyName('first_name'), null);
        $secondAllergy = new Allergy(AllergyId::random(), new AllergyName('second_name'), null);

        $this->insert(Allergy::primitiveName(), $firstAllergy->toPrimitives());
        $this->insert(Allergy::primitiveName(), $secondAllergy->toPrimitives());

        $response = $this->httpGet('get-allergies');

        $responseData = json_decode($response->getContent(), true);

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertIsArray($responseData);
        $this->assertCount(2, $responseData);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->deleteAll(Allergy::primitiveName());
    }
}
