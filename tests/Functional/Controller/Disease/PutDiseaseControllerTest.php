<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller\Disease;

use App\Tests\Functional\FunctionalTestCase;
use Doctrine\DBAL\Exception;
use DogCare\Disease\Domain\Disease;
use DogCare\Disease\Domain\DiseaseDescription;
use DogCare\Disease\Domain\DiseaseId;
use DogCare\Disease\Domain\DiseaseName;
use DogCare\Shared\Domain\ValueObject\UpdatedAt;
use Symfony\Component\HttpFoundation\Response;

class PutDiseaseControllerTest extends FunctionalTestCase
{
    /**
     * @throws Exception
     */
    public function testPutDiseaseUpdateNameOkResponse(): void
    {
        $diseaseData = new Disease(
            DiseaseId::random(),
            new DiseaseName('Name'),
            new DiseaseDescription('Description'),
        )->toPrimitives();

        $this->insert(Disease::primitiveName(), $diseaseData);

        $diseaseData[DiseaseName::primitiveName()] = 'Name Updated';

        $response = $this->httpPut(
            'put-disease',
            ['id' => $diseaseData[DiseaseId::primitiveName()]],
            $diseaseData,
        );

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());

        $storedDisease = $this->findById(Disease::primitiveName(), new DiseaseId($diseaseData[DiseaseId::primitiveName()]));

        $this->assertEquals($diseaseData[DiseaseName::primitiveName()], $storedDisease[DiseaseName::primitiveName()]);
        $this->assertNotNull($storedDisease[UpdatedAt::primitiveName()]);
    }

    /**
     * @throws Exception
     */
    public function testPutDiseaseUpdateDescriptionOkResponse(): void
    {
        $diseaseData = new Disease(
            DiseaseId::random(),
            new DiseaseName('Name'),
            new DiseaseDescription('Description'),
        )->toPrimitives();

        $this->insert(Disease::primitiveName(), $diseaseData);

        $diseaseData[DiseaseDescription::primitiveName()] = 'Description Updated';

        $response = $this->httpPut(
            'put-disease',
            ['id' => $diseaseData[DiseaseId::primitiveName()]],
            $diseaseData,
        );

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());

        $storedDisease = $this->findById(Disease::primitiveName(), new DiseaseId($diseaseData[DiseaseId::primitiveName()]));

        $this->assertEquals(
            $diseaseData[DiseaseDescription::primitiveName()],
            $storedDisease[DiseaseDescription::primitiveName()],
        );
        $this->assertNotNull($storedDisease[UpdatedAt::primitiveName()]);
    }

    public function testPutDiseaseUpdateWithoutNameBadRequestResponse(): void
    {
        $diseaseData = new Disease(
            DiseaseId::random(),
            new DiseaseName('Name'),
            new DiseaseDescription('Description'),
        )->toPrimitives();

        $this->insert(Disease::primitiveName(), $diseaseData);

        unset($diseaseData[DiseaseName::primitiveName()]);

        $response = $this->httpPut(
            'put-disease',
            ['id' => $diseaseData[DiseaseId::primitiveName()]],
            $diseaseData,
        );

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function testPutDiseaseUpdateWithoutDescriptionBadRequestResponse(): void
    {
        $diseaseData = new Disease(
            DiseaseId::random(),
            new DiseaseName('Name'),
            new DiseaseDescription('Description'),
        )->toPrimitives();

        $this->insert(Disease::primitiveName(), $diseaseData);

        unset($diseaseData[DiseaseDescription::primitiveName()]);

        $response = $this->httpPut(
            'put-disease',
            ['id' => $diseaseData[DiseaseId::primitiveName()]],
            $diseaseData,
        );

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    /**
     * @throws Exception
     */
    public function testPutDiseaseUpdateDescriptionWithNullOkResponse(): void
    {
        $diseaseData = new Disease(
            DiseaseId::random(),
            new DiseaseName('Name'),
            new DiseaseDescription('Description'),
        )->toPrimitives();

        $this->insert(Disease::primitiveName(), $diseaseData);

        $diseaseData[DiseaseDescription::primitiveName()] = null;

        $response = $this->httpPut(
            'put-disease',
            ['id' => $diseaseData[DiseaseId::primitiveName()]],
            $diseaseData,
        );

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());

        $storedDisease = $this->findById(Disease::primitiveName(), new DiseaseId($diseaseData[DiseaseId::primitiveName()]));

        $this->assertNull($storedDisease[DiseaseDescription::primitiveName()]);
        $this->assertNotNull($storedDisease[UpdatedAt::primitiveName()]);
    }

    public function testPutDiseaseWithRandomIdNotFoundResponse(): void
    {
        $diseaseData = new Disease(
            DiseaseId::random(),
            new DiseaseName('Name'),
            new DiseaseDescription('Description'),
        )->toPrimitives();

        $response = $this->httpPut(
            'put-disease',
            ['id' => $diseaseData[DiseaseId::primitiveName()]],
            $diseaseData,
        );

        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->deleteAll(Disease::primitiveName());
    }
}
