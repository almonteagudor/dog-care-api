<?php

declare(strict_types=1);

namespace DogCare\Shared\Infrastructure\Exception;

use DogCare\Shared\Domain\Exception\AlreadyStoredException;
use DogCare\Shared\Domain\Exception\InvalidUuidException;
use DogCare\Shared\Domain\Exception\MaxLengthValueException;
use DogCare\Shared\Domain\Exception\MissingParamException;
use DogCare\Shared\Domain\Exception\NotFoundException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\InvalidParameterException;

final class ApiExceptionsHttpStatusCodeMapping
{
    private const int DEFAULT_STATUS_CODE = Response::HTTP_INTERNAL_SERVER_ERROR;

    /** @var array<string, int> */
    private array $exceptions = [
        AlreadyStoredException::class => Response::HTTP_CONFLICT,
        InvalidParameterException::class => Response::HTTP_BAD_REQUEST,
        InvalidUuidException::class => Response::HTTP_BAD_REQUEST,
        MaxLengthValueException::class => Response::HTTP_BAD_REQUEST,
        MissingParamException::class => Response::HTTP_BAD_REQUEST,
        NotFoundException::class => Response::HTTP_NOT_FOUND,
    ];

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
