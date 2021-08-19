<?php

namespace Models;

use Components\Connection;
use DBQueries\InsertQueryBuilder;

/**
 * Base adding model implementation.
 */
final class BaseAdding implements Adding
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
    public function added(array $data): static
    {
        $this->connection->query(
            (new InsertQueryBuilder($this->table))
                ->set($data)
        );
        return $this;
    }
}
