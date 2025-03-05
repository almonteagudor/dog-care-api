<?php

declare(strict_types=1);

namespace App\Controller\Medicine;

use DogCare\Medicine\Application\Create\CreateMedicineCommand;
use DogCare\Medicine\Domain\MedicineDescription;
use DogCare\Medicine\Domain\MedicineName;
use DogCare\Shared\Infrastructure\Symfony\ApiController;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PostMedicineController extends ApiController
{
    /**
     * @throws Exception
     */
    public function __invoke(Request $request, string $id): JsonResponse
    {
        $body = $this->body($request);

        $this->dispatch(
            new CreateMedicineCommand(
                $id,
                $body[MedicineName::primitiveName()],
                $body[MedicineDescription::primitiveName()] ?? null,
            ),
        );

        return new JsonResponse(null, Response::HTTP_CREATED);
    }

    protected function exceptions(): array
    {
        return [];
    }

    protected function mandatoryParams(): array
    {
        return [MedicineName::primitiveName(), MedicineDescription::primitiveName()];
    }

    protected function notNullableParams(): array
    {
        return [MedicineName::primitiveName()];
    }
}
