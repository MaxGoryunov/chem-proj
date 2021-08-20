<?php

namespace Entities\Queries;

use Components\Connection;

/**
 * Base loyalty implementation.
 */
final class BsLoyalty implements Loyalty
{

    /**
     * {@inheritDoc}
     */
    public function loyalTo(
        Connection $connection,
        string $table,
        int $id
    ): ColumnQuery {
        return new BaseColumnQuery($connection, $table, $id);
    }
}
