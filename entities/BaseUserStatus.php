<?php

namespace Entities;

use Components\Connection;
use DBQueries\SelectQueryBuilder;
use Entities\Queries\ColumnQuery;
use Entities\Queries\Loyalty;

/**
 * Base user status implementation.
 */
final class BaseUserStatus implements UserStatus
{

    /**
     * Database query.
     * 
     * @var ColumnQuery
     */
    private ColumnQuery $query;

    /**
     * Ctor.
     * 
     * @param Connection $connection database connection.
     * @param int        $id         id.
     * @param Loyalty    $loyalty    query loyalty.
     */
    public function __construct(
        /**
         * Database connection.
         * 
         * @var Connection
         */
        private Connection $connection,

        /**
         * Id.
         * 
         * @var int
         */
        private int $id,
        Loyalty $loyalty
    ) {
        $this->query = $loyalty->loyalTo(
            $connection,
            "user_statuses",
            $id
        );
    }

    /**
     * {@inheritDoc}
     */
    public function id(): int
    {
        return $this->id;
    }

    /**
     *{@inheritDoc}
     */
    public function name(): string
    {
        return $this->query->result("name");
    }
}
