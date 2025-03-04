<?php

declare(strict_types=1);

namespace DogCare\Allergy\Application\Find;

use DogCare\Allergy\Domain\AllergyFinder;
use DogCare\Allergy\Domain\AllergyId;
use DogCare\Shared\Domain\Bus\Query\QueryHandler;

final readonly class FindAllergyQueryHandler implements QueryHandler
{
    public function __construct(public AllergyFinder $finder)
    {
    }

    public function __invoke(FindAllergyQuery $query): AllergyResponse
    {
        $allergy = $this->finder->findById(new AllergyId($query->id));

        return AllergyResponse::fromAllergy($allergy);
    }
}
