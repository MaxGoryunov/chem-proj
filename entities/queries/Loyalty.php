<?php

namespace Entities\Queries;

use Components\Connection;

/**
 * Interface for queries which cannot be constructed as is.
 */
interface Loyalty
{

    /**
     * Returns a loyal query.
     *
     * @param Connection $connection database connection.
     * @param string     $table      table name.
     * @param int        $id         entity id.
     * @return ColumnQuery
     */
    public function loyalTo(
        Connection $connection,
        string $table,
        int $id
    ): ColumnQuery;
}
