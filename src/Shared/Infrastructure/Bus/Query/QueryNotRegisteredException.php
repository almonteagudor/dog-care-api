<?php

declare(strict_types=1);

namespace DogCare\Shared\Infrastructure\Bus\Query;

use DogCare\Shared\Domain\Bus\Query\Query;
use RuntimeException;

final class QueryNotRegisteredException extends RuntimeException
{
    public function __construct(Query $query)
    {
        $queryClass = get_class($query);

        parent::__construct("The query <$queryClass> hasn't a query handler associated");
    }
}
