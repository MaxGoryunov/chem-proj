<?php

namespace Models;

use Components\Connection;
use DBQueries\UpdateQueryBuilder;
use stdClass;

/**
 * Base deleting model implementation.
 */
final class BaseDeleting implements Deleting
{

    /**
     * Ctor.
     * 
     * @param Connection $connection database connection.
     * @param string     $table      table name.
     */
    public function __construct(
        /**
         * Database connection.
         *
         * @var Connection
         */
        private Connection $connection,

        /**
         * Database table.
         *
         * @var string
         */
        private string $table
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function deleted(int $id): static
    {
        $this->connection->query(
            (new UpdateQueryBuilder($this->table))
                ->set(["is_deleted" => 1])
                ->where("`id` = " . $id)
        );
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function entity(int $id): object
    {
        return new stdClass();
    }
}
