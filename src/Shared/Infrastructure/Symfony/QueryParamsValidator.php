<?php

declare(strict_types=1);

namespace DogCare\Shared\Infrastructure\Symfony;

use DogCare\Shared\Domain\Criteria\OrderType;
use InvalidArgumentException;

final class QueryParamsValidator
{
    /**
     * @return array<array-key, mixed>
     */
    public function validateFilters(mixed $filters): array
    {
        if (!is_array($filters)) {
            throw new InvalidArgumentException(sprintf('Expected array for filters, got %s.', gettype($filters)));
        }

        return $filters;
    }

    public function validateOrder(mixed $order): ?string
    {
        if ($order !== null && OrderType::tryFrom($order) === null) {
            throw new InvalidArgumentException(
                sprintf(
                    'Invalid value "%s" for order. Allowed values are: %s.',
                    $order,
                    implode(', ', array_map(fn (OrderType $type) => $type->value, OrderType::cases())),
                ),
            );
        }

        return $order;
    }

    public function validateString(mixed $value, string $name): ?string
    {
        if (!is_string($value) && $value !== null) {
            throw new InvalidArgumentException(
                sprintf('Expected string or null for "%s", got %s.', $name, gettype($value)),
            );
        }

        return $value;
    }

    public function validateInt(mixed $value, string $name): ?int
    {
        if (!is_int($value) && $value !== null) {
            if (is_numeric($value)) {
                return (int) $value;
            }

            throw new InvalidArgumentException(
                sprintf('Expected int or null for "%s", got %s.', $name, gettype($value)),
            );
        }

        return $value;
    }
}
