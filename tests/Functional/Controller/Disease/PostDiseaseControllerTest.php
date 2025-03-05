<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller\Disease;

use App\Tests\Functional\FunctionalTestCase;
use DogCare\Disease\Domain\Disease;
use DogCare\Disease\Domain\DiseaseDescription;
use DogCare\Disease\Domain\DiseaseId;
use DogCare\Disease\Domain\DiseaseName;
use Symfony\Component\HttpFoundation\Response;

class PostDiseaseControllerTest extends FunctionalTestCase
{
    public function testPostDiseaseCreatedResponse(): void
    {
        $disease = new Disease(DiseaseId::random(), new DiseaseName('Name'), new DiseaseDescription('Description'));

        $response = $this->httpPost(
            'post-disease',
            ['id' => $disease->id->value()],
            $disease->toPrimitives(),
        );

        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());

        $storedDisease = $this->findById(Disease::primitiveName(), $disease->id);

        $this->assertEquals($disease->id->value(), $storedDisease[DiseaseId::primitiveName()]);
        $this->assertEquals($disease->name->value(), $storedDisease[DiseaseName::primitiveName()]);
        $this->assertEquals($disease->description->value(), $storedDisease[DiseaseDescription::primitiveName()]);
    }

    public function testPostDiseaseWithoutNameBadRequestResponse(): void
    {
        $diseaseData = new Disease(
            DiseaseId::random(),
            new DiseaseName('Name'),
            new DiseaseDescription('Description'),
        )->toPrimitives();

        unset($diseaseData[DiseaseName::primitiveName()]);

        $response = $this->httpPost(
            'post-disease',
            ['id' => $diseaseData[DiseaseId::primitiveName()]],
            $diseaseData,
        );

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function testPostDiseaseWithoutDescriptionBadRequestResponse(): void
    {
        $diseaseData = new Disease(
            DiseaseId::random(),
            new DiseaseName('Name'),
            new DiseaseDescription('Description'),
        )->toPrimitives();

        unset($diseaseData[DiseaseDescription::primitiveName()]);

        $response = $this->httpPost(
            'post-disease',
            ['id' => $diseaseData[DiseaseId::primitiveName()]],
            $diseaseData,
        );

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function testPostDiseaseWithNullNameBadRequestResponse(): void
    {
        $diseaseData = new Disease(
            DiseaseId::random(),
            new DiseaseName('Name'),
            new DiseaseDescription('Description'),
        )->toPrimitives();

        $diseaseData[DiseaseName::primitiveName()] = null;

        $response = $this->httpPost(
            'post-disease',
            ['id' => $diseaseData[DiseaseId::primitiveName()]],
            $diseaseData,
        );

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function testPostDiseaseWithNullDescriptionOkResponse(): void
    {
        $diseaseData = new Disease(
            DiseaseId::random(),
            new DiseaseName('Name'),
            new DiseaseDescription('Description'),
        )->toPrimitives();

        $diseaseData[DiseaseDescription::primitiveName()] = null;

        $response = $this->httpPost(
            'post-disease',
            ['id' => $diseaseData[DiseaseId::primitiveName()]],
            $diseaseData,
        );

        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());

        $storedDisease = $this->findById(
            Disease::primitiveName(),
            new DiseaseId($diseaseData[DiseaseId::primitiveName()]),
        );

        $this->assertEquals($diseaseData[DiseaseId::primitiveName()], $storedDisease[DiseaseId::primitiveName()]);
        $this->assertEquals($diseaseData[DiseaseName::primitiveName()], $storedDisease[DiseaseName::primitiveName()]);
        $this->assertNull($storedDisease[DiseaseDescription::primitiveName()]);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->deleteAll(Disease::primitiveName());
    }
}
