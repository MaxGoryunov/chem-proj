<?php

namespace Entities;

use Components\Connection;
use DBQueries\SelectQueryBuilder;

/**
 * Base gender implementation.
 */
final class BaseGender implements Gender
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
         * Gender id in database.
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
     * {@inheritDoc}
     */
    public function name(): string
    {
        return $this->connection->query(
            (new SelectQueryBuilder("genders", ["name"]))
            ->where("`gender_id` = {$this->id}")
        )->fetchAssoc();
    }

    /**
     * {@inheritDoc}
     */
    public function shortName(): string
    {
        return $this->connection->query(
            (new SelectQueryBuilder("genders", ["short_name"]))
            ->where("`gender_id` = {$this->id}")
        )->fetchAssoc();
    }
}
