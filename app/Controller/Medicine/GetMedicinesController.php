<?php

declare(strict_types=1);

namespace App\Controller\Medicine;

use DogCare\Medicine\Application\Find\FindMedicinesByCriteriaQuery;
use DogCare\Shared\Infrastructure\Symfony\ApiController;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class GetMedicinesController extends ApiController
{
    /**
     * @throws Exception
     */
    public function __invoke(Request $request): JsonResponse
    {

        $response = $this->ask(
            new FindMedicinesByCriteriaQuery(
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
