<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller\Allergy;

use App\Tests\Functional\FunctionalTestCase;
use Doctrine\DBAL\Exception;
use DogCare\Allergy\Domain\Allergy;
use DogCare\Allergy\Domain\AllergyDescription;
use DogCare\Allergy\Domain\AllergyId;
use DogCare\Allergy\Domain\AllergyName;
use DogCare\Shared\Domain\ValueObject\UpdatedAt;
use Symfony\Component\HttpFoundation\Response;

class PutAllergyControllerTest extends FunctionalTestCase
{
    /**
     * @throws Exception
     */
    public function testPutAllergyUpdateNameOkResponse(): void
    {
        $allergyData = new Allergy(
            AllergyId::random(),
            new AllergyName('Name'),
            new AllergyDescription('Description'),
        )->toPrimitives();

        $this->insert(Allergy::primitiveName(), $allergyData);

        $allergyData[AllergyName::primitiveName()] = 'Name Updated';

        $response = $this->httpPut(
            'put-allergy',
            ['id' => $allergyData[AllergyId::primitiveName()]],
            $allergyData,
        );

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());

        $storedAllergy = $this->findById(Allergy::primitiveName(), new AllergyId($allergyData[AllergyId::primitiveName()]));

        $this->assertEquals($allergyData[AllergyName::primitiveName()], $storedAllergy[AllergyName::primitiveName()]);
        $this->assertNotNull($storedAllergy[UpdatedAt::primitiveName()]);
    }

    /**
     * @throws Exception
     */
    public function testPutAllergyUpdateDescriptionOkResponse(): void
    {
        $allergyData = new Allergy(
            AllergyId::random(),
            new AllergyName('Name'),
            new AllergyDescription('Description'),
        )->toPrimitives();

        $this->insert(Allergy::primitiveName(), $allergyData);

        $allergyData[AllergyDescription::primitiveName()] = 'Description Updated';

        $response = $this->httpPut(
            'put-allergy',
            ['id' => $allergyData[AllergyId::primitiveName()]],
            $allergyData,
        );

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());

        $storedAllergy = $this->findById(Allergy::primitiveName(), new AllergyId($allergyData[AllergyId::primitiveName()]));

        $this->assertEquals(
            $allergyData[AllergyDescription::primitiveName()],
            $storedAllergy[AllergyDescription::primitiveName()],
        );
        $this->assertNotNull($storedAllergy[UpdatedAt::primitiveName()]);
    }

    public function testPutAllergyUpdateWithoutNameBadRequestResponse(): void
    {
        $allergyData = new Allergy(
            AllergyId::random(),
            new AllergyName('Name'),
            new AllergyDescription('Description'),
        )->toPrimitives();

        $this->insert(Allergy::primitiveName(), $allergyData);

        unset($allergyData[AllergyName::primitiveName()]);

        $response = $this->httpPut(
            'put-allergy',
            ['id' => $allergyData[AllergyId::primitiveName()]],
            $allergyData,
        );

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function testPutAllergyUpdateWithoutDescriptionBadRequestResponse(): void
    {
        $allergyData = new Allergy(
            AllergyId::random(),
            new AllergyName('Name'),
            new AllergyDescription('Description'),
        )->toPrimitives();

        $this->insert(Allergy::primitiveName(), $allergyData);

        unset($allergyData[AllergyDescription::primitiveName()]);

        $response = $this->httpPut(
            'put-allergy',
            ['id' => $allergyData[AllergyId::primitiveName()]],
            $allergyData,
        );

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    /**
     * @throws Exception
     */
    public function testPutAllergyUpdateDescriptionWithNullOkResponse(): void
    {
        $allergyData = new Allergy(
            AllergyId::random(),
            new AllergyName('Name'),
            new AllergyDescription('Description'),
        )->toPrimitives();

        $this->insert(Allergy::primitiveName(), $allergyData);

        $allergyData[AllergyDescription::primitiveName()] = null;

        $response = $this->httpPut(
            'put-allergy',
            ['id' => $allergyData[AllergyId::primitiveName()]],
            $allergyData,
        );

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());

        $storedAllergy = $this->findById(Allergy::primitiveName(), new AllergyId($allergyData[AllergyId::primitiveName()]));

        $this->assertNull($storedAllergy[AllergyDescription::primitiveName()]);
        $this->assertNotNull($storedAllergy[UpdatedAt::primitiveName()]);
    }

    public function testPutAllergyWithRandomIdNotFoundResponse(): void
    {
        $allergyData = new Allergy(
            AllergyId::random(),
            new AllergyName('Name'),
            new AllergyDescription('Description'),
        )->toPrimitives();

        $response = $this->httpPut(
            'put-allergy',
            ['id' => $allergyData[AllergyId::primitiveName()]],
            $allergyData,
        );

        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->deleteAll(Allergy::primitiveName());
    }
}
