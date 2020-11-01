<?php

    namespace Components;

    use OutOfRangeException;
use SplObjectStorage;

/**
     * Class for storing instantiated Domains
     */
    class DomainRegistry {

        /**
         * Stores array data required to create new Domain instances
         *
         * @var string[][]
         */
        private static $domainData = [[]];

        /**
         * Stores instantiated Domains
         *
         * @var Domain[]
         */
        private static $domains = [];

        /**
         * @todo Write a method description after stash apply
         */
        public function setDomainData(string $filePath):void {
            if (self::$domainData !== [[]]) {
                return;
            }
            
            if (file_exists($filePath)) {
                self::$domainData = include_once($filePath);
            }
        }

        public function getDomainData():array {
            return self::$domainData;
        }

        public function getDomain(string $domainName):Domain {
            if (isset(self::$domains[$domainName])) {
                return self::$domains[$domainName];
            }

            if (!isset(self::$domainData[$domainName])) {
                throw new OutOfRangeException("Domain not found");
            }

            $domainData = self::$domainData[$domainName];

            self::$domains[$domainName] = (new Domain($domainName))
                      ->setDomainSingular($domainData[0]);

            if ((isset($domainData[1])) && (isset($domainData[2]))) {
                self::$domains[$domainName]->setTranslation($domainData[1], $domainData[2]);
            }

            return self::$domains[$domainName];
        }
    }