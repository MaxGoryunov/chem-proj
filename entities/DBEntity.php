<?php

namespace Entities;

use Components\Connection;
use Components\Indifferent;
use DBQueries\SelectQueryBuilder;

/**
 * Base class for database entities.
 */
abstract class DBEntity implements Indifferent
{

    public function __construct(
        /**
         * Database connection.
         * 
         * @var Connection
         */
        private Connection $connection,

        /**
         * Entity id.
         * 
         * @var int
         */
        private int $id
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function __call(string $method, array $args): mixed
    {
        return $this->connection->query(
            (new SelectQueryBuilder("addresses", ["name"]))
            ->where("`address_id` = {$this->id}")
        )->fetchAssoc();
    }
}
