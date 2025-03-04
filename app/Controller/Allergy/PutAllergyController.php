<?php

declare(strict_types=1);

namespace App\Controller\Allergy;

use DogCare\Allergy\Application\Update\UpdateAllergyCommand;
use DogCare\Allergy\Domain\AllergyDescription;
use DogCare\Allergy\Domain\AllergyName;
use DogCare\Shared\Infrastructure\Symfony\ApiController;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PutAllergyController extends ApiController
{
    /**
     * @throws Exception
     */
    public function __invoke(Request $request, string $id): JsonResponse
    {
        $body = $this->body($request);

        $this->dispatch(new UpdateAllergyCommand($id, $body['name'], $body['description'] ?? null));

        return new JsonResponse(null, Response::HTTP_OK);
    }

    protected function exceptions(): array
    {
        return [];
    }

    protected function mandatoryParams(): array
    {
        return [AllergyName::primitiveName(), AllergyDescription::primitiveName()];
    }

    protected function notNullableParams(): array
    {
        return [AllergyName::primitiveName()];
    }
}
