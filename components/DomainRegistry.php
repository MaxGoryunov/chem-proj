<?php

    namespace Components;

    use OutOfRangeException;

    /**
     * Class for storing instantiated Domains
     */
    class DomainRegistry {

        private static $domainData = [];

        public static function setDomainData(string $filePath):void {
            if (file_exists($filePath)) {
                self::$domainData = include_once($filePath);
            }
        }

        public static function getDomainData():array {
            return self::$domainData;
        }

        public static function getDomain(string $domainName) {
            throw new OutOfRangeException("Domain not found");
        }
    }