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
                AllergyId::primitiveName() => AllergyId::random(),
                AllergyName::primitiveName() => 'Alergia alimentaria',
                AllergyDescription::primitiveName() => 'Reacción adversa a ciertos ingredientes en la dieta, como pollo, trigo, soja o lácteos, causando picazón, vómitos o diarrea',
                CreatedAt::primitiveName() => new CreatedAt()->value(),
            ],
            [
                AllergyId::primitiveName() => AllergyId::random(),
                AllergyName::primitiveName() => 'Alergia ambiental',
                AllergyDescription::primitiveName() => 'Respuesta alérgica a factores ambientales como el polen, el moho o los ácaros del polvo, provocando estornudos, picazón y lagrimeo',
                CreatedAt::primitiveName() => new CreatedAt()->value(),
            ],
            [
                AllergyId::primitiveName() => AllergyId::random(),
                AllergyName::primitiveName() => 'Alergia a picaduras de pulgas',
                AllergyDescription::primitiveName() => 'Hipersensibilidad a la saliva de las pulgas, causando inflamación intensa, pérdida de pelo y rascado excesivo',
                CreatedAt::primitiveName() => new CreatedAt()->value(),
            ],
            [
                AllergyId::primitiveName() => AllergyId::random(),
                AllergyName::primitiveName() => 'Alergia de contacto',
                AllergyDescription::primitiveName() => 'Reacción cutánea causada por el contacto con materiales como plásticos, tintes o productos de limpieza, generando irritación y enrojecimiento',
                CreatedAt::primitiveName() => new CreatedAt()->value(),
            ],
            [
                AllergyId::primitiveName() => AllergyId::random(),
                AllergyName::primitiveName() => 'Alergia medicamentosa',
                AllergyDescription::primitiveName() => 'Reacción adversa a ciertos medicamentos, como antibióticos o antiinflamatorios, que puede causar síntomas leves o graves, como erupciones o anafilaxia',
                CreatedAt::primitiveName() => new CreatedAt()->value(),
            ],
            [
                AllergyId::primitiveName() => AllergyId::random(),
                AllergyName::primitiveName() => 'Alergia a perfumes y químicos',
                AllergyDescription::primitiveName() => 'Sensibilidad a fragancias o productos químicos en champús, aerosoles o detergentes, provocando irritación cutánea y problemas respiratorios',
                CreatedAt::primitiveName() => new CreatedAt()->value(),
            ],
            [
                AllergyId::primitiveName() => AllergyId::random(),
                AllergyName::primitiveName() => 'Alergia a ácaros del polvo',
                AllergyDescription::primitiveName() => 'Reacción a los ácaros presentes en el hogar, causando estornudos, picazón y problemas respiratorios en los perros sensibles',
                CreatedAt::primitiveName() => new CreatedAt()->value(),
            ],
        ];
    }
}
