<?php

namespace Components;

use Connections\Result;
use DBQueries\IQueryBuilder;
use Entities\IEntity;

/**
 * Interface for various Database Connections such as MySQL, PostgreSQL etc.
 */
interface Connection
{

    /**
     * Performs a Database query
     *
     * @param IQueryBuilder $builder
     * @return Result
     */
    public function query(IQueryBuilder $builder): Result;

    // /**
    //  * Returns all matched rows from Database Table
    //  *
    //  * @param IQueryBuilder $builder
    //  * @param int $resultType
    //  * @return array
    //  */
    // public function fetchAll(IQueryBuilder $builder, int $resultType = 1):array;

    // /**
    //  * Returns a single matched row from Database Table
    //  *
    //  * @param IQueryBuilder $builder
    //  * @return array|string
    //  */
    // public function fetchAssoc(IQueryBuilder $builder, string $alias = "");

    // /**
    //  * Returns a new object of the given class
    //  *
    //  * @param IQueryBuilder $builder - builder for retrieving a query string
    //  * @param string $className      - name of the class of the resulting object
    //  * @return object
    //  */
    // public function fetchObject(IQueryBuilder $builder, string $className):object;

    // /**
    //  * Returns an array of objects of the given class
    //  *
    //  * @param IQueryBuilder $builder - builder for retrieving a query string
    //  * @param string $className      - class name of the result object array
    //  * @return object[]
    //  */
    // public function fetchObjects(IQueryBuilder $builder, string $className):array;
}
