<?php

declare(strict_types=1);

namespace App\Tests\DataFixtures\Data;

use DogCare\Allergy\Domain\Allergy;
use DogCare\Allergy\Domain\AllergyDescription;
use DogCare\Allergy\Domain\AllergyId;
use DogCare\Allergy\Domain\AllergyName;
use DogCare\Shared\Domain\ValueObject\CreatedAt;

class AllergyDataFixture extends DataFixture
{
    public static function tableName(): string
    {
        return Allergy::primitiveName();
    }

    public static function data(): array
    {
        return [
            [
                AllergyId::primitiveName() => '1e82fbd6-9cb4-4b28-a64e-e0a9f2622283',
                AllergyName::primitiveName() => 'Alergia alimentaria',
                AllergyDescription::primitiveName() => 'Reacción adversa a ciertos ingredientes en la dieta, como pollo, trigo, soja o lácteos, causando picazón, vómitos o diarrea',
                CreatedAt::primitiveName() => new CreatedAt()->value(),
            ],
            [
                AllergyId::primitiveName() => '3963f10d-c29c-49bd-ba53-307d46d5447d',
                AllergyName::primitiveName() => 'Alergia ambiental',
                AllergyDescription::primitiveName() => 'Respuesta alérgica a factores ambientales como el polen, el moho o los ácaros del polvo, provocando estornudos, picazón y lagrimeo',
                CreatedAt::primitiveName() => new CreatedAt()->value(),
            ],
            [
                AllergyId::primitiveName() => '58c184e9-43b5-4262-b1de-ebd8f6db9a84',
                AllergyName::primitiveName() => 'Alergia a picaduras de pulgas',
                AllergyDescription::primitiveName() => 'Hipersensibilidad a la saliva de las pulgas, causando inflamación intensa, pérdida de pelo y rascado excesivo',
                CreatedAt::primitiveName() => new CreatedAt()->value(),
            ],
            [
                AllergyId::primitiveName() => '97fb94d0-808f-4527-8fa2-01cd7585b31a',
                AllergyName::primitiveName() => 'Alergia de contacto',
                AllergyDescription::primitiveName() => 'Reacción cutánea causada por el contacto con materiales como plásticos, tintes o productos de limpieza, generando irritación y enrojecimiento',
                CreatedAt::primitiveName() => new CreatedAt()->value(),
            ],
            [
                AllergyId::primitiveName() => 'afd1b9e7-e344-4174-abba-176ae57deb1c',
                AllergyName::primitiveName() => 'Alergia medicamentosa',
                AllergyDescription::primitiveName() => 'Reacción adversa a ciertos medicamentos, como antibióticos o antiinflamatorios, que puede causar síntomas leves o graves, como erupciones o anafilaxia',
                CreatedAt::primitiveName() => new CreatedAt()->value(),
            ],
            [
                AllergyId::primitiveName() => 'f1cb3dcf-a02a-480d-aca6-64a63ceb3fe3',
                AllergyName::primitiveName() => 'Alergia a perfumes y químicos',
                AllergyDescription::primitiveName() => 'Sensibilidad a fragancias o productos químicos en champús, aerosoles o detergentes, provocando irritación cutánea y problemas respiratorios',
                CreatedAt::primitiveName() => new CreatedAt()->value(),
            ],
            [
                AllergyId::primitiveName() => 'f341bbf1-22eb-463d-95f4-328e322dcadf',
                AllergyName::primitiveName() => 'Alergia a ácaros del polvo',
                AllergyDescription::primitiveName() => 'Reacción a los ácaros presentes en el hogar, causando estornudos, picazón y problemas respiratorios en los perros sensibles',
                CreatedAt::primitiveName() => new CreatedAt()->value(),
            ],
        ];
    }
}
