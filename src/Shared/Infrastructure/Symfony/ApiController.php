<?php

namespace DogCare\Shared\Infrastructure\Symfony;

use DogCare\Shared\Domain\Bus\Command\Command;
use DogCare\Shared\Domain\Bus\Command\CommandBus;
use DogCare\Shared\Domain\Bus\Query\Query;
use DogCare\Shared\Domain\Bus\Query\QueryBus;
use DogCare\Shared\Domain\Bus\Query\Response;
use DogCare\Shared\Domain\Exception\MissingParamException;
use DogCare\Shared\Infrastructure\Exception\ApiExceptionsHttpStatusCodeMapping;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use function Lambdish\Phunctional\each;

abstract class ApiController
{
    public function __construct(
        private readonly QueryBus $queryBus,
        private readonly CommandBus $commandBus,
        ApiExceptionsHttpStatusCodeMapping $exceptionHandler,
    ) {
        each(
            fn (int $httpCode, string $exceptionClass) => $exceptionHandler->register($exceptionClass, $httpCode),
            $this->exceptions(),
        );
    }

    /** @return array<string, int> */
    abstract protected function exceptions(): array;

    protected function ask(Query $query): ?Response
    {
        return $this->queryBus->ask($query);
    }

    protected function dispatch(Command $command): void
    {
        $this->commandBus->dispatch($command);
    }

    /**
     * @return array<string, mixed>
     * @throws MissingParamException
     *
     * @throws Exception
     */
    protected function body(Request $request): array
    {
        $data = $request->attributes->get('body');

        $this->validateRecursively($data, $this->mandatoryParams());
        $this->validateRequiredParams($data, $this->notNullableParams());

        return $data;
    }

    /**
     * @param array<string, mixed> $data
     * @param array<int, mixed> $mandatory
     *
     * @throws MissingParamException
     */
    protected function validateRecursively(array $data, array $mandatory, string $prefix = ''): void
    {
        foreach ($mandatory as $key => $value) {
            if (is_int($key)) {
                $paramName = $value;

                if (!array_key_exists($paramName, $data)) {
                    throw new MissingParamException(
                        $this->appendPrefix($prefix, $paramName),
                    );
                }
            } else {
                if (!array_key_exists($key, $data)) {
                    throw new MissingParamException(
                        $this->appendPrefix($prefix, $key),
                    );
                }

                if (!is_array($data[$key])) {
                    throw new MissingParamException('not an array ' . $this->appendPrefix($prefix, $key));
                }

                $this->validateRecursively($data[$key], $value, $this->appendPrefix($prefix, $key));
            }
        }
    }

    protected function appendPrefix(string $prefix, string $field): string
    {
        if (!$prefix) {
            return $field;
        }

        return $prefix . '.' . $field;
    }

    /** @return array<int|string, array<int, string>|string>. */
    abstract protected function mandatoryParams(): array;

    /**
     * @param array<string, mixed> $data
     * @param array<int|string, string|array<int, string>> $required
     *
     * @throws MissingParamException
     */
    protected function validateRequiredParams(array $data, array $required): void
    {
        foreach ($required as $key => $requiredParam) {
            if (is_array($requiredParam)) {
                $this->validateRequiredParams($data[$key], $requiredParam);
            } else {
                if (array_key_exists($requiredParam, $data) && $data[$requiredParam] === null) {
                    throw new MissingParamException("Required parameter '{$requiredParam}' cannot be null");
                }

                if (array_key_exists($requiredParam, $data) && is_array(
                        $data[$requiredParam],
                    ) && empty($data[$requiredParam])) {
                    throw new MissingParamException("Required array '{$requiredParam}' cannot be empty");
                }
            }
        }
    }

    /** @return array<int, string> */
    abstract protected function notNullableParams(): array;

    protected function getOrder(Request $request): ?string
    {
        return $this->getQueryParam('order', $request);
    }

    private function getQueryParam(string $key, Request $request, mixed $default = null): mixed
    {
        $queryParams = $request->attributes->get('query_params', []);

        return $queryParams[$key] ?? $default;
    }

    /**
     * @return array<string, mixed>
     */
    protected function getFilters(Request $request): array
    {
        return $this->getQueryParam('filters', $request, []);
    }

    protected function getOrderBy(Request $request): ?string
    {
        return $this->getQueryParam('orderBy', $request);
    }

    protected function getLimit(Request $request): ?int
    {
        return $this->getQueryParam('limit', $request);
    }

    protected function getOffset(Request $request): ?int
    {
        return $this->getQueryParam('offset', $request);
    }
}
