<?php

    interface IDBConnection {

        public function getConnection():mysqli;
    }