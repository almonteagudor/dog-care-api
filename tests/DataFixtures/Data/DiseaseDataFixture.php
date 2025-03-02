<?php

declare(strict_types=1);

namespace App\Tests\DataFixtures\Data;

use DogCare\Disease\Domain\Disease;
use DogCare\Disease\Domain\DiseaseDescription;
use DogCare\Disease\Domain\DiseaseId;
use DogCare\Disease\Domain\DiseaseName;
use DogCare\Shared\Domain\ValueObject\CreatedAt;

class DiseaseDataFixture extends DataFixture
{
    public static function tableName(): string
    {
        return Disease::primitiveName();
    }

    public static function data(): array
    {
        return [
            [
                DiseaseId::primitiveName() => '1856079f-1c87-4945-bf48-ff2aa692267e',
                DiseaseName::primitiveName() => 'Parvovirus Canino',
                DiseaseDescription::primitiveName() => 'Enfermedad viral altamente contagiosa que afecta el sistema digestivo y cardiovascular de los perros, especialmente cachorros no vacunados.',
                CreatedAt::primitiveName() => new CreatedAt()->value(),
            ],
            [
                DiseaseId::primitiveName() => '3cc7f346-9901-424f-8aaa-a53bb7f3b40b',
                DiseaseName::primitiveName() => 'Moquillo Canino',
                DiseaseDescription::primitiveName() => 'Enfermedad viral grave que afecta el sistema respiratorio, digestivo y nervioso de los perros, causando fiebre, secreción nasal y convulsiones.',
                CreatedAt::primitiveName() => new CreatedAt()->value(),
            ],
            [
                DiseaseId::primitiveName() => '486d673c-07e2-433b-8a89-fb7159171cd3',
                DiseaseName::primitiveName() => 'Leptospirosis',
                DiseaseDescription::primitiveName() => 'Infección bacteriana transmitida por el contacto con orina de animales infectados. Puede causar insuficiencia renal y hepática.',
                CreatedAt::primitiveName() => new CreatedAt()->value(),
            ],
            [
                DiseaseId::primitiveName() => '4ccb17cf-b84b-4c1c-bbc8-018c5ae0fb20',
                DiseaseName::primitiveName() => 'Rabia',
                DiseaseDescription::primitiveName() => 'Enfermedad viral mortal que afecta el sistema nervioso central, causando cambios de comportamiento, agresividad y parálisis.',
                CreatedAt::primitiveName() => new CreatedAt()->value(),
            ],
            [
                DiseaseId::primitiveName() => '5ce0b4ca-e69b-4133-818f-0a0eef33a7dc',
                DiseaseName::primitiveName() => 'Tos de las Perreras',
                DiseaseDescription::primitiveName() => 'Infección respiratoria altamente contagiosa causada por bacterias y virus, que provoca tos seca persistente y dificultad para respirar.',
                CreatedAt::primitiveName() => new CreatedAt()->value(),
            ],
            [
                DiseaseId::primitiveName() => '94d1c283-864b-4f2b-aa84-bf88e951bfa6',
                DiseaseName::primitiveName() => 'Ehrlichiosis Canina',
                DiseaseDescription::primitiveName() => 'Enfermedad transmitida por garrapatas que afecta los glóbulos blancos, causando fiebre, letargo y sangrado anormal.',
                CreatedAt::primitiveName() => new CreatedAt()->value(),
            ],
            [
                DiseaseId::primitiveName() => 'ac045b30-a77f-475d-b98a-991372f54b28',
                DiseaseName::primitiveName() => 'Filariasis Canina',
                DiseaseDescription::primitiveName() => 'Enfermedad causada por parásitos del corazón transmitidos por mosquitos, que pueden provocar insuficiencia cardíaca y respiratoria.',
                CreatedAt::primitiveName() => new CreatedAt()->value(),
            ],
            [
                DiseaseId::primitiveName() => 'b5442db2-0764-4a6c-9508-442883ccd61e',
                DiseaseName::primitiveName() => 'Gastroenteritis Hemorrágica',
                DiseaseDescription::primitiveName() => 'Trastorno gastrointestinal caracterizado por vómitos y diarrea con sangre, generalmente causado por infecciones o intoxicaciones.',
                CreatedAt::primitiveName() => new CreatedAt()->value(),
            ],
            [
                DiseaseId::primitiveName() => 'd66f858e-41b9-4ca4-8412-605fb977d5a2',
                DiseaseName::primitiveName() => 'Sarna Demodécica',
                DiseaseDescription::primitiveName() => 'Enfermedad de la piel causada por ácaros Demodex, que provoca pérdida de pelo, enrojecimiento y picazón intensa.',
                CreatedAt::primitiveName() => new CreatedAt()->value(),
            ],
            [
                DiseaseId::primitiveName() => 'dd45c907-74e2-4f60-996a-ee14064d3558',
                DiseaseName::primitiveName() => 'Anaplasmosis Canina',
                DiseaseDescription::primitiveName() => 'Infección transmitida por garrapatas que afecta los glóbulos rojos, causando fiebre, letargo y cojera.',
                CreatedAt::primitiveName() => new CreatedAt()->value(),
            ],
        ];
    }
}
