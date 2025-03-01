<?php

declare(strict_types=1);

namespace DogCare\Shared\Domain\Criteria;

final readonly class Criteria
{
    private ?Order $order;

    public function __construct(
        private Filters $filters,
        ?Order $order = null,
        private ?int $offset = null,
        private ?int $limit = null,
    ) {
        $this->order = $order ?? Order::none();
    }

    public function hasFilters(): bool
    {
        return $this->filters->count() > 0;
    }

    public function hasOrder(): bool
    {
        return !$this->order->isNone();
    }

    /**
     * @return array<string, mixed>
     */
    public function plainFilters(): array
    {
        return $this->filters->filters();
    }

    public function filters(): Filters
    {
        return $this->filters;
    }

    public function order(): Order
    {
        return $this->order;
    }

    public function offset(): ?int
    {
        return $this->offset;
    }

    public function hasOffset(): bool
    {
        return $this->offset !== null;
    }

    public function hasLimit(): bool
    {
        return $this->limit !== null;
    }

    public function limit(): ?int
    {
        return $this->limit;
    }

    public function serialize(): string
    {
        return sprintf(
            '%s~~%s~~%s~~%s',
            $this->filters->serialize(),
            $this->order->serialize(),
            $this->offset,
            $this->limit,
        );
    }
}
