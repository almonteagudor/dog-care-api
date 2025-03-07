<?php

declare(strict_types=1);

namespace DogCare\Shared\Domain\Criteria;

use DogCare\Shared\Domain\Collection\Collection;
use function Lambdish\Phunctional\reduce;

/**
 * @extends Collection<int, Filter>
 */
final class Filters extends Collection
{
    /**
     * @param array<int, array<string, mixed>> $values
     */
    public static function fromValues(array $values): self
    {
        return new self(array_map(self::filterBuilder(), $values));
    }

    private static function filterBuilder(): callable
    {
        return static fn (array $values) => Filter::fromValues($values);
    }

    /**
     * @return array<Filter>
     */
    public function filters(): array
    {
        return $this->items();
    }

    public function serialize(): string
    {
        return reduce(
            static fn (string $accumulate, Filter $filter) => sprintf('%s^%s', $accumulate, $filter->serialize()),
            $this->items(),
            '',
        );
    }

    protected function type(): string
    {
        return Filter::class;
    }
}
