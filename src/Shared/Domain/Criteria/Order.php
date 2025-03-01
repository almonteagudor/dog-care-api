<?php

declare(strict_types=1);

namespace DogCare\Shared\Domain\Criteria;

final readonly class Order
{
    public function __construct(
        private OrderBy $orderBy,
        private OrderType $orderType,
    ) {
    }

    public static function createDesc(OrderBy $orderBy): Order
    {
        return new self($orderBy, OrderType::DESC);
    }

    public static function createAsc(OrderBy $orderBy): Order
    {
        return new self($orderBy, OrderType::ASC);
    }

    public static function fromValues(?string $orderBy = null, ?string $order = null): Order
    {
        return null === $orderBy ? self::none() : new Order(new OrderBy($orderBy), OrderType::tryFrom($order));
    }

    public static function none(): Order
    {
        return new Order(new OrderBy(''), OrderType::NONE);
    }

    public function orderBy(): OrderBy
    {
        return $this->orderBy;
    }

    public function isNone(): bool
    {
        return $this->orderType() === OrderType::NONE;
    }

    public function orderType(): OrderType
    {
        return $this->orderType;
    }

    public function serialize(): string
    {
        return sprintf('%s.%s', $this->orderBy->value(), $this->orderType->value);
    }
}
