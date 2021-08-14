<?php

namespace Entities\Queries;

use Components\Connection;
use DBQueries\SelectQueryBuilder;

/**
 * Base database column query.
 */
final class BaseColumnQuery implements ColumnQuery
{

    /**
     * Ctor.
     * 
     * @param Connection $connection database connection.
     * @param string     $table      table name.
     * @param int        $id         entity id.
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
         */
        private string $table,

        /**
         * Target entity id.
         * 
         * @var int
         */
        private int $id
    ) {
    }

    /**
     * {@inheritdoc}
     */
    public function result(string $column): string
    {
        return $this->connection->query(
            (new SelectQueryBuilder($this->table, [$column]))
                ->where("`id` = {$this->id}")
        )->fetchAssoc();
    }
}
