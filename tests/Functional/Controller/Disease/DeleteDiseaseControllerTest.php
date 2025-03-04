<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller\Disease;

use App\Tests\Functional\FunctionalTestCase;
use Doctrine\DBAL\Exception;
use DogCare\Disease\Domain\Disease;
use DogCare\Disease\Domain\DiseaseDescription;
use DogCare\Disease\Domain\DiseaseId;
use DogCare\Disease\Domain\DiseaseName;
use DogCare\Shared\Domain\ValueObject\DeletedAt;
use Symfony\Component\HttpFoundation\Response;

class DeleteDiseaseControllerTest extends FunctionalTestCase
{
    /**
     * @throws Exception
     */
    public function testDeleteDiseaseNoContentResponse(): void
    {
        $diseaseData = new Disease(
            DiseaseId::random(),
            new DiseaseName('Name'),
            new DiseaseDescription('Description'),
        )->toPrimitives();

        $this->insert(Disease::primitiveName(), $diseaseData);

        $response = $this->httpDelete('delete-disease', ['id' => $diseaseData[DiseaseId::primitiveName()]]);

        $this->assertEquals(Response::HTTP_NO_CONTENT, $response->getStatusCode());

        $storedDisease = $this->findById(Disease::primitiveName(), new DiseaseId($diseaseData[DiseaseId::primitiveName()]));

        $this->assertNotNull($storedDisease[DeletedAt::primitiveName()]);
    }

    public function testDeleteDiseaseWithRandomIdNotFoundResponse(): void
    {
        $response = $this->httpDelete('put-disease', ['id' => DiseaseId::random()->value()]);

        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->deleteAll(Disease::primitiveName());
    }
}
