<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller\Allergy;

use App\Tests\Functional\FunctionalTestCase;
use DogCare\Allergy\Domain\Allergy;
use DogCare\Allergy\Domain\AllergyDescription;
use DogCare\Allergy\Domain\AllergyId;
use DogCare\Allergy\Domain\AllergyName;
use Symfony\Component\HttpFoundation\Response;

class GetAllergyControllerTest extends FunctionalTestCase
{
    public function testGetAllergyOkResponse(): void
    {
        $allergy = new Allergy(AllergyId::random(), new AllergyName('name'), new AllergyDescription('description'));

        $this->insert(Allergy::primitiveName(), $allergy->toPrimitives());

        $response = $this->httpGet('get-allergy', ['id' => $allergy->id->value()]);

        $responseData = json_decode($response->getContent(), true);

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertEquals($allergy->id->value(), $responseData[AllergyId::primitiveName()]);
        $this->assertEquals($allergy->name->value(), $responseData[AllergyName::primitiveName()]);
        $this->assertEquals($allergy->description->value(), $responseData[AllergyDescription::primitiveName()]);
    }

    public function testGetAllergyWithRandomIdNotFoundResponse(): void
    {
        $response = $this->httpGet('get-allergy', ['id' => AllergyId::random()->value()]);

        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->deleteAll(Allergy::primitiveName());
    }
}
