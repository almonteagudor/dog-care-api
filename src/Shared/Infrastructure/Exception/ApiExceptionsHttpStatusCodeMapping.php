<?php

declare(strict_types=1);

namespace DogCare\Shared\Infrastructure\Exception;

use Symfony\Component\HttpFoundation\Response;

final class ApiExceptionsHttpStatusCodeMapping
{
    private const int DEFAULT_STATUS_CODE = Response::HTTP_INTERNAL_SERVER_ERROR;

    /** @var array<string, int> */
    private array $exceptions = [];

    public function register(string $exceptionClass, int $statusCode): void
    {
        $this->exceptions[$exceptionClass] = $statusCode;
    }

    public function statusCodeFor(string $exceptionClass): int
    {
        foreach ($this->exceptions as $registeredException => $statusCode) {
            if (is_a($exceptionClass, $registeredException, true)) {
                return $statusCode;
            }
        }

        return self::DEFAULT_STATUS_CODE;
    }
}
