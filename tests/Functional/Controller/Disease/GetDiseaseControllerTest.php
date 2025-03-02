<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller\Disease;

use App\Tests\Functional\FunctionalTestCase;
use DogCare\Disease\Domain\Disease;
use DogCare\Disease\Domain\DiseaseDescription;
use DogCare\Disease\Domain\DiseaseId;
use DogCare\Disease\Domain\DiseaseName;
use Symfony\Component\HttpFoundation\Response;

class GetDiseaseControllerTest extends FunctionalTestCase
{
    public function testGetDiseaseOkResponse(): void
    {
        $disease = new Disease(DiseaseId::random(), new DiseaseName('name'), new DiseaseDescription('description'));

        $this->insert(Disease::primitiveName(), $disease->toPrimitives());

        $response = $this->httpGet('get-disease', ['id' => $disease->id->value()]);

        $responseData = json_decode($response->getContent(), true);

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertEquals($disease->id->value(), $responseData[DiseaseId::primitiveName()]);
        $this->assertEquals($disease->name->value(), $responseData[DiseaseName::primitiveName()]);
        $this->assertEquals($disease->description->value(), $responseData[DiseaseDescription::primitiveName()]);
    }

    public function testGetDiseaseWithRandomIdNotFoundResponse(): void
    {
        $response = $this->httpGet('get-disease', ['id' => DiseaseId::random()->value()]);

        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->deleteAll(Disease::primitiveName());
    }
}
