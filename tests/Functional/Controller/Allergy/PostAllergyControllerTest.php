<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller\Allergy;

use App\Tests\Functional\FunctionalTestCase;
use DogCare\Allergy\Domain\Allergy;
use DogCare\Allergy\Domain\AllergyDescription;
use DogCare\Allergy\Domain\AllergyId;
use DogCare\Allergy\Domain\AllergyName;
use Symfony\Component\HttpFoundation\Response;

class PostAllergyControllerTest extends FunctionalTestCase
{
    public function testPostAllergyCreatedResponse(): void
    {
        $allergy = new Allergy(AllergyId::random(), new AllergyName('Name'), new AllergyDescription('Description'));

        $response = $this->httpPost(
            'post-allergy',
            ['id' => $allergy->id->value()],
            $allergy->toPrimitives(),
        );

        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());

        $storedAllergy = $this->findById(Allergy::primitiveName(), $allergy->id);

        $this->assertEquals($allergy->id->value(), $storedAllergy[AllergyId::primitiveName()]);
        $this->assertEquals($allergy->name->value(), $storedAllergy[AllergyName::primitiveName()]);
        $this->assertEquals($allergy->description->value(), $storedAllergy[AllergyDescription::primitiveName()]);
    }

    public function testPostAllergyWithoutNameBadRequestResponse(): void
    {
        $allergyData = new Allergy(
            AllergyId::random(),
            new AllergyName('Name'),
            new AllergyDescription('Description'),
        )->toPrimitives();

        unset($allergyData[AllergyName::primitiveName()]);

        $response = $this->httpPost(
            'post-allergy',
            ['id' => $allergyData[AllergyId::primitiveName()]],
            $allergyData,
        );

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function testPostAllergyWithoutDescriptionBadRequestResponse(): void
    {
        $allergyData = new Allergy(
            AllergyId::random(),
            new AllergyName('Name'),
            new AllergyDescription('Description'),
        )->toPrimitives();

        unset($allergyData[AllergyDescription::primitiveName()]);

        $response = $this->httpPost(
            'post-allergy',
            ['id' => $allergyData[AllergyId::primitiveName()]],
            $allergyData,
        );

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function testPostAllergyWithNullNameBadRequestResponse(): void
    {
        $allergyData = new Allergy(
            AllergyId::random(),
            new AllergyName('Name'),
            new AllergyDescription('Description'),
        )->toPrimitives();

        $allergyData[AllergyName::primitiveName()] = null;

        $response = $this->httpPost(
            'post-allergy',
            ['id' => $allergyData[AllergyId::primitiveName()]],
            $allergyData,
        );

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function testPostAllergyWithNullDescriptionOkResponse(): void
    {
        $allergyData = new Allergy(
            AllergyId::random(),
            new AllergyName('Name'),
            new AllergyDescription('Description'),
        )->toPrimitives();

        $allergyData[AllergyDescription::primitiveName()] = null;

        $response = $this->httpPost(
            'post-allergy',
            ['id' => $allergyData[AllergyId::primitiveName()]],
            $allergyData,
        );

        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());

        $storedAllergy = $this->findById(
            Allergy::primitiveName(),
            new AllergyId($allergyData[AllergyId::primitiveName()]),
        );

        $this->assertEquals($allergyData[AllergyId::primitiveName()], $storedAllergy[AllergyId::primitiveName()]);
        $this->assertEquals($allergyData[AllergyName::primitiveName()], $storedAllergy[AllergyName::primitiveName()]);
        $this->assertNull($storedAllergy[AllergyDescription::primitiveName()]);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->deleteAll(Allergy::primitiveName());
    }
}
