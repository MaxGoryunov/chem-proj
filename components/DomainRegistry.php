<?php

    namespace Components;

    use OutOfRangeException;

    /**
     * Class for storing instantiated Domains
     */
    class DomainRegistry {

        private static $domainData = [];

        /**
         * @todo Write a method description after stash apply
         */
        public static function setDomainData(string $filePath):void {
            if (self::$domainData !== []) {
                return;
            }
            
            if (file_exists($filePath)) {
                self::$domainData = include_once($filePath);
            }
        }

        public static function getDomainData():array {
            return self::$domainData;
        }

        public static function getDomain(string $domainName):Domain {
            if (!isset(self::$domainData[$domainName])) {
                throw new OutOfRangeException("Domain not found");
            }

            $domainData = self::$domainData[$domainName];

            $domain = (new Domain($domainName))
                      ->setDomainSingular($domainData[0])
                      ->setFactoryName($domainData[1]);

            if ((isset($domainData[2])) && (isset($domainData[3]))) {
                $domain->setTranslation($domainData[2], $domainData[3]);
            }

            return $domain;
        }
    }