<?php

    namespace Components;
    
    /**
     * Interface for various Database Connections such as MySQL, PostgreSQL etc.
     */
    interface IDBConnection {

        /**
         * Returns a Database Connection
         *
         * @return mixed
         */
        public function getConnection();
    }