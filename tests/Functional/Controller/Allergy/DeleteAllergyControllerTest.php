<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller\Allergy;

use App\Tests\Functional\FunctionalTestCase;
use Doctrine\DBAL\Exception;
use DogCare\Allergy\Domain\Allergy;
use DogCare\Allergy\Domain\AllergyDescription;
use DogCare\Allergy\Domain\AllergyId;
use DogCare\Allergy\Domain\AllergyName;
use DogCare\Shared\Domain\ValueObject\DeletedAt;
use Symfony\Component\HttpFoundation\Response;

class DeleteAllergyControllerTest extends FunctionalTestCase
{
    /**
     * @throws Exception
     */
    public function testDeleteAllergyNoContentResponse(): void
    {
        $allergyData = new Allergy(
            AllergyId::random(),
            new AllergyName('Name'),
            new AllergyDescription('Description'),
        )->toPrimitives();

        $this->insert(Allergy::primitiveName(), $allergyData);

        $response = $this->httpDelete('delete-allergy', ['id' => $allergyData[AllergyId::primitiveName()]]);

        $this->assertEquals(Response::HTTP_NO_CONTENT, $response->getStatusCode());

        $storedAllergy = $this->findById(Allergy::primitiveName(), new AllergyId($allergyData[AllergyId::primitiveName()]));

        $this->assertNotNull($storedAllergy[DeletedAt::primitiveName()]);
    }

    public function testDeleteAllergyWithRandomIdNotFoundResponse(): void
    {
        $response = $this->httpDelete('put-allergy', ['id' => AllergyId::random()->value()]);

        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->deleteAll(Allergy::primitiveName());
    }
}
