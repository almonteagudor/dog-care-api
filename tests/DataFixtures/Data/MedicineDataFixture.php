<?php

declare(strict_types=1);

namespace App\Tests\DataFixtures\Data;

use DogCare\Medicine\Domain\Medicine;
use DogCare\Medicine\Domain\MedicineDescription;
use DogCare\Medicine\Domain\MedicineId;
use DogCare\Medicine\Domain\MedicineName;
use DogCare\Shared\Domain\ValueObject\CreatedAt;

class MedicineDataFixture extends DataFixture
{
    public static function tableName(): string
    {
        return Medicine::primitiveName();
    }

    public static function data(): array
    {
        return [
            [
                MedicineId::primitiveName() => '1154c350-2960-4bb5-b690-7ee7f49752c6',
                MedicineName::primitiveName() => 'Carprofeno',
                MedicineDescription::primitiveName() => 'Antiinflamatorio no esteroideo (AINE) utilizado para aliviar el dolor y la inflamación en perros con artritis o después de cirugías',
                CreatedAt::primitiveName() => new CreatedAt()->value(),
            ],
            [
                MedicineId::primitiveName() => '37d05600-8352-4198-abcf-73e3f13cec75',
                MedicineName::primitiveName() => 'Firocoxib',
                MedicineDescription::primitiveName() => 'AINE utilizado para tratar el dolor y la inflamación asociados con la osteoartritis en perros',
                CreatedAt::primitiveName() => new CreatedAt()->value(),
            ],
            [
                MedicineId::primitiveName() => '78c69d57-76d2-46dd-b21e-552aa166b0b7',
                MedicineName::primitiveName() => 'Amoxicilina',
                MedicineDescription::primitiveName() => 'Antibiótico de amplio espectro utilizado para tratar infecciones bacterianas en perros, como infecciones de piel, vías respiratorias y urinarias',
                CreatedAt::primitiveName() => new CreatedAt()->value(),
            ],
            [
                MedicineId::primitiveName() => '7c3fadb6-fbb2-439a-9b69-bcbd52e52dc8',
                MedicineName::primitiveName() => 'Metronidazol',
                MedicineDescription::primitiveName() => 'Antibiótico y antiparasitario usado para tratar infecciones gastrointestinales, como giardiasis y colitis en perros',
                CreatedAt::primitiveName() => new CreatedAt()->value(),
            ],
            [
                MedicineId::primitiveName() => 'a5ef603e-493b-4c87-b14c-cc038cfa156b',
                MedicineName::primitiveName() => 'Prednisolona',
                MedicineDescription::primitiveName() => 'Corticosteroide utilizado para tratar afecciones inflamatorias y alérgicas en perros',
                CreatedAt::primitiveName() => new CreatedAt()->value(),
            ],
            [
                MedicineId::primitiveName() => 'a96864e0-e517-4e5d-a0d0-784849d90a59',
                MedicineName::primitiveName() => 'Fenobarbital',
                MedicineDescription::primitiveName() => 'Medicamento anticonvulsivo utilizado en el tratamiento de la epilepsia en perros',
                CreatedAt::primitiveName() => new CreatedAt()->value(),
            ],
            [
                MedicineId::primitiveName() => 'bd95bd7b-03aa-4927-a7ca-67dcea0ca8f2',
                MedicineName::primitiveName() => 'Ivermectina',
                MedicineDescription::primitiveName() => 'Antiparasitario utilizado para el tratamiento y prevención de parásitos internos y externos, como gusanos del corazón y sarna',
                CreatedAt::primitiveName() => new CreatedAt()->value(),
            ],
            [
                MedicineId::primitiveName() => 'd6576c01-541f-4f3e-b582-6ef70cfa1b4f',
                MedicineName::primitiveName() => 'Apoquel (Oclacitinib)',
                MedicineDescription::primitiveName() => 'Medicamento para el tratamiento del picor y las alergias en perros, especialmente en casos de dermatitis atópica',
                CreatedAt::primitiveName() => new CreatedAt()->value(),
            ],
            [
                MedicineId::primitiveName() => 'f16d4bb5-be6a-4473-be7c-170b36275e0a',
                MedicineName::primitiveName() => 'Gabapentina',
                MedicineDescription::primitiveName() => 'Medicamento utilizado para tratar el dolor neuropático y como coadyuvante en el tratamiento de convulsiones en perros',
                CreatedAt::primitiveName() => new CreatedAt()->value(),
            ],
            [
                MedicineId::primitiveName() => 'f9ba5689-5062-4512-8088-e1b3ffa3c109',
                MedicineName::primitiveName() => 'Maropitant (Cerenia)',
                MedicineDescription::primitiveName() => 'Antiemético utilizado para prevenir y tratar los vómitos en perros, especialmente en casos de mareo por movimiento o gastritis',
                CreatedAt::primitiveName() => new CreatedAt()->value(),
            ],
        ];
    }
}
