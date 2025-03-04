<?php

declare(strict_types=1);

namespace App\Controller\Allergy;

use DogCare\Allergy\Application\Find\FindAllergyQuery;
use DogCare\Shared\Infrastructure\Symfony\ApiController;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class GetAllergyController extends ApiController
{
    /**
     * @throws Exception
     */
    public function __invoke(Request $request, string $id): JsonResponse
    {

        $response = $this->ask(new FindAllergyQuery($id));

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
