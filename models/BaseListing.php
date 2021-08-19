<?php

namespace Models;

use Components\Connection;
use DBQueries\SelectQueryBuilder;

/**
 * Base listing model implementation.
 */
final class BaseListing implements Listing
{

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
        private string $table,

        /**
         * Amount of values to get.
         *
         * @var int
         */
        private int $count = 5,

        /**
         * Values offset.
         *
         * @var int
         */
        private int $offset = 0
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function withCount(int $count): static
    {
        return new self(
            $this->connection,
            $this->table,
            $count,
            $this->offset
        );
    }

    /**
     * {@inheritDoc}
     */
    public function withOffset(int $offset): static
    {
        return new self(
            $this->connection,
            $this->table,
            $this->count,
            $offset
        );
    }

    /**
     * {@inheritDoc}
     */
    public function list(): array
    {
        return $this->connection->query(
            (new SelectQueryBuilder($this->table))
                ->where("`is_deleted` = 0")
                ->limit($this->count, $this->offset)
        )->fetchAll();
    }
}
