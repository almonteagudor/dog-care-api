<?php

declare(strict_types=1);

namespace App\Controller\Disease;

use DogCare\Disease\Application\Update\UpdateDiseaseCommand;
use DogCare\Disease\Domain\DiseaseDescription;
use DogCare\Disease\Domain\DiseaseName;
use DogCare\Shared\Infrastructure\Symfony\ApiController;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PutDiseaseController extends ApiController
{
    /**
     * @throws Exception
     */
    public function __invoke(Request $request, string $id): JsonResponse
    {
        $body = $this->body($request);

        $this->dispatch(new UpdateDiseaseCommand($id, $body['name'], $body['description'] ?? null));

        return new JsonResponse(null, Response::HTTP_OK);
    }

    protected function exceptions(): array
    {
        return [];
    }

    protected function mandatoryParams(): array
    {
        return [DiseaseName::primitiveName(), DiseaseDescription::primitiveName()];
    }

    protected function notNullableParams(): array
    {
        return [DiseaseName::primitiveName()];
    }
}
