<?php

namespace Entities\Queries;

use Closure;
use Components\Connection;

/**
 * Loyalty which returns a column query based on the given function.
 */
final class FuncLoyalty implements Loyalty
{

    /**
     * Ctor.
     * 
     * @param Closure $query closure with a column query.
     * Closure signature should be like the following:
     * `Closure(Connection, string, id): ColumnQuery`
     */
    public function __construct(
        /**
         * Closure with a column query.
         *
         * @var Closure
         */
        private Closure $query
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function loyalTo(
        Connection $connection,
        string $table,
        int $id
    ): ColumnQuery {
        return ($this->query)($connection, $table, $id);
    }
}
