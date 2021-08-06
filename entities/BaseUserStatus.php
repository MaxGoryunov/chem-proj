<?php

namespace Entities;

use Components\Connection;
use DBQueries\SelectQueryBuilder;

/**
 * Base user status implementation.
 */
final class BaseUserStatus implements UserStatus
{

    /**
     * Ctor.
     * 
     * @param Connection $connection database connection.
     * @param int        $id         id.
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
        private int $id
    ) {
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
        return $this->connection->query(
            (new SelectQueryBuilder("user_statuses", ["name"]))
            ->where("`user_status_id` = {$this->id}")
        )->fetchAssoc();
    }
}
