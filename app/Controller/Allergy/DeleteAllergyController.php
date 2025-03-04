<?php

declare(strict_types=1);

namespace App\Controller\Allergy;

use DogCare\Allergy\Application\Delete\DeleteAllergyCommand;
use DogCare\Shared\Infrastructure\Symfony\ApiController;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DeleteAllergyController extends ApiController
{
    /**
     * @throws Exception
     */
    public function __invoke(Request $request, string $id): JsonResponse
    {
        $this->dispatch(new DeleteAllergyCommand($id));

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
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
