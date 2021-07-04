<?php

    namespace Domains;

    use InvalidArgumentException;

    /**
     * Class used to retrieve different domain related strings, such as domain name in singular
     */
    class BaseDomain implements Domain {

        /**
         * Name of the domain in plural
         *
         * @var string
         */
        private string $domain;

        /**
         * Ctor.
         *
         * @param string $domain
         */
        public function __construct(string $domain) {
            $this->domain = $domain;
        }

        /**
         * {@inheritDoc}
         *
         * @return array{singular: string, plural: string}
         */
        public function forms(): array {
            return include("./config/domainData.php")[$this->domain];
        }
    }