<?php

namespace Models;

use Components\Connection;
use DBQueries\UpdateQueryBuilder;
use stdClass;

/**
 * Base editing model implementation.
 */
final class BaseEditing implements Editing
{

    /**
     * Ctor.
     * 
     * @param Connection $connection database connection.
     * @param string     $table      table name.
     */
    public function __construct(
        /**
         * Batabase connection.
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
    public function edited(array $data): static
    {
        $this->connection->query(
            (new UpdateQueryBuilder($this->table))
                ->set($data)
                ->where("`id` = " . $data["id"])
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
