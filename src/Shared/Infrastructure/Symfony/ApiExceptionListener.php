<?php

declare(strict_types=1);

namespace DogCare\Shared\Infrastructure\Symfony;

use DogCare\Shared\Domain\Exception\DomainException;
use DogCare\Shared\Domain\Utils\Utils;
use DogCare\Shared\Infrastructure\Exception\ApiExceptionsHttpStatusCodeMapping;
use ReflectionClass;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Throwable;

final readonly class ApiExceptionListener
{
    public function __construct(private ApiExceptionsHttpStatusCodeMapping $exceptionHandler)
    {
    }

    public function onException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        assert($exception instanceof Throwable);

        $event->setResponse(
            new JsonResponse(
                [
                    'code' => $this->exceptionCodeFor($exception),
                    'message' => $exception->getMessage(),
                ],
                $this->exceptionHandler->statusCodeFor(get_class($exception)),
            ),
        );
    }

    private function exceptionCodeFor(Throwable $error): string
    {
        $domainErrorClass = DomainException::class;

        return $error instanceof $domainErrorClass
            ? $error->errorCode()
            : Utils::toSnakeCase($this->extractClassName($error));
    }

    private function extractClassName(object $object): string
    {
        $reflect = new ReflectionClass($object);

        return $reflect->getShortName();
    }
}
