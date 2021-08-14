<?php

namespace Entities\Queries;

/**
 * Query for column in a database.
 */
interface ColumnQuery
{

    /**
     * Returns value of an entity column.
     *
     * @param string $column column name.
     * @return string
     */
    public function result(string $column): string;
}
