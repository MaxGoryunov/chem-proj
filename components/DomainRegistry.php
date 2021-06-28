<?php

    namespace Components;

    use OutOfRangeException;
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
         * Sets the file from which the domain data will be extracted
         *
         * @param string $filePath
         * @return void
         */
        public function setDomainData(string $filePath = "./config/domainData.php"):void {
            if (self::$domainData !== [[]]) {
                return;
            }
            
            if (file_exists($filePath)) {
                self::$domainData = include($filePath);
            }
        }

        /**
         * Returns the domain data from which Domain instances are built
         *
         * @return string[][]
         */
        public function getDomainData():array {
            return self::$domainData;
        }

        /**
         * Returns a Domain based on the supplied domainPlural string
         *
         * @param string $domainName
         * @return Domain
         */
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