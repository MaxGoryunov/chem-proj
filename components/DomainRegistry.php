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
        public function setDomainData(string $filePath):void {
            if (self::$domainData !== []) {
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
            if (!isset(self::$domainData[$domainName])) {
                throw new OutOfRangeException("Domain not found");
            }

            $domainData = self::$domainData[$domainName];

            $domain = (new Domain($domainName))
                      ->setDomainSingular($domainData[0]);

            if ((isset($domainData[1])) && (isset($domainData[2]))) {
                $domain->setTranslation($domainData[1], $domainData[2]);
            }

            return $domain;
        }
    }