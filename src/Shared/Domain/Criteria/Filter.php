<?php

declare(strict_types=1);

namespace DogCare\Shared\Domain\Criteria;

final readonly class Filter
{
    public function __construct(
        private FilterField $field,
        private FilterOperator $operator,
        private FilterValue $value,
    ) {
    }

    /**
     * @param array<string, mixed> $values
     */
    public static function fromValues(array $values): self
    {
        return new self(
            new FilterField($values['field']),
            FilterOperator::tryFrom($values['operator']),
            new FilterValue($values['value']),
        );
    }

    public function field(): FilterField
    {
        return $this->field;
    }

    public function operator(): FilterOperator
    {
        return $this->operator;
    }

    public function serialize(): string
    {
        return sprintf('%s.%s.%s', $this->field->value(), $this->operator->value, $this->value->value());
    }

    public function value(): FilterValue
    {
        return $this->value;
    }
}
