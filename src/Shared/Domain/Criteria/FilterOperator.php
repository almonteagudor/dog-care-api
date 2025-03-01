<?php

declare(strict_types=1);

namespace DogCare\Shared\Domain\Criteria;

use function in_array;

enum FilterOperator: string
{
    case EQUAL = '=';
    case NOT_EQUAL = '!=';
    case GT = '>';
    case LT = '<';
    case CONTAINS = 'CONTAINS';
    case NOT_CONTAINS = 'NOT_CONTAINS';
    case GTE = '>=';
    case LTE = '<=';

    public function isContaining(): bool
    {
        return in_array($this->value, [self::CONTAINS->value, self::NOT_CONTAINS->value], true);
    }
}
