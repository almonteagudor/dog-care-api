<?php

declare(strict_types=1);

namespace App\Controller\Client;

use DogCare\Client\Application\Create\CreateClientCommand;
use DogCare\Client\Domain\ClientEmail;
use DogCare\Client\Domain\ClientName;
use DogCare\Client\Domain\ClientPhone;
use DogCare\Client\Domain\ClientSurname;
use DogCare\Shared\Infrastructure\Symfony\ApiController;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PostClientController extends ApiController
{
    /**
     * @throws Exception
     */
    public function __invoke(Request $request, string $id): JsonResponse
    {
        $body = $this->body($request);

        $this->dispatch(
            new CreateClientCommand(
                $id,
                $body[ClientName::primitiveName()],
                $body[ClientSurname::primitiveName()],
                $body[ClientPhone::primitiveName()],
                $body[ClientEmail::primitiveName()],
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
        return [
            ClientName::primitiveName(),
            ClientSurname::primitiveName(),
            ClientPhone::primitiveName(),
            ClientEmail::primitiveName(),
        ];
    }

    protected function notNullableParams(): array
    {
        return [
            ClientName::primitiveName(),
            ClientSurname::primitiveName(),
            ClientPhone::primitiveName(),
            ClientEmail::primitiveName(),
        ];
    }
}
