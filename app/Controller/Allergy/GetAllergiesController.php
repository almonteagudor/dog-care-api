<?php

declare(strict_types=1);

namespace App\Controller\Allergy;

use DogCare\Allergy\Application\Find\FindAllergiesByCriteriaQuery;
use DogCare\Shared\Infrastructure\Symfony\ApiController;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class GetAllergiesController extends ApiController
{
    /**
     * @throws Exception
     */
    public function __invoke(Request $request): JsonResponse
    {

        $response = $this->ask(
            new FindAllergiesByCriteriaQuery(
                $this->getFilters($request),
                $this->getOrderBy($request),
                $this->getOrder($request),
                $this->getLimit($request),
                $this->getOffset($request),
            ),
        );

        return new JsonResponse($response->toPrimitives());
    }

    protected function exceptions(): array
    {
        return [];
    }

    protected function mandatoryParams(): array
    {
        return [];
    }

    protected function notNullableParams(): array
    {
        return [];
    }
}
