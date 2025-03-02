<?php

declare(strict_types=1);

namespace DogCare\Disease\Application\Find;

use DogCare\Disease\Domain\DiseaseFinder;
use DogCare\Disease\Domain\DiseaseId;
use DogCare\Shared\Domain\Bus\Query\QueryHandler;

final readonly class FindDiseaseQueryHandler implements QueryHandler
{
    public function __construct(public DiseaseFinder $finder)
    {
    }

    public function __invoke(FindDiseaseQuery $query): DiseaseResponse
    {
        $disease = $this->finder->findById(new DiseaseId($query->id));

        return DiseaseResponse::fromDisease($disease);
    }
}
