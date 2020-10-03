<?php

    namespace Components;

use InvalidArgumentException;

/**
     * Class used to retrieve different domain related strings, such as factory name
     */
    class Domain {

        /**
         * Name of the domain in plural
         *
         * @var string
         */
        private $domainPlural;

        /**
         * Name of the domain in singular
         *
         * @var string
         */
        private $domainSingular;

        /**
         * Name of the related factory
         *
         * @var string
         */
        private $factoryName;

        /**
         * Translated equivalent of the domain name
         * 
         * As manual translation is yet to be introduced, the translated version of the domain has to be stored manually
         *
         * @var string
         */
        private $translation;

        /**
         * A clause variant of the translated domain name
         * 
         * It is used in template pages(add, edit and delete)
         *
         * @var string
         */
        private $translationClause;

        /**
         * @param string $domainPlural
         */
        public function __construct(string $domainPlural) {
            $this->domainPlural = $domainPlural;
        }

        /**
         * Sets domain name in singular
         *
         * @param string $domainSingular
         * @return self
         */
        public function setDomainSingular(string $domainSingular):self {
            $this->domainSingular = $domainSingular;

            return $this;
        }

        /**
         * Sets related factory name
         *
         * @param string $factoryName
         * @return self
         */
        public function setFactoryName(string $factoryName):self {
            if ($factoryName === "") {
                throw new InvalidArgumentException("Factory name must be a valid string");
            }

            $this->factoryName = $factoryName;

            return $this;
        }

        /**
         * Sets translated versions of domain name
         *
         * @param string $translation - translated versions of domain name
         * @param string $translationClause - clause version of domain name
         * @return self
         */
        public function setTranslation(string $translation, string $translationClause):self {
            if ($translation === "") {
                throw new InvalidArgumentException("Translation must be a valid string");
            }
            if ($translationClause === "") {
                throw new InvalidArgumentException("Translation clause must be a valid string");
            }
            
            $this->translation       = $translation;
            $this->translationClause = $translationClause;

            return $this;
        }

        /**
         * Returns domain name in plural
         *
         * @return string
         */
        public function getDomainPlural():string {
            return $this->domainPlural;
        }

        /**
         * Returns domain name in singular
         *
         * @return string
         */
        public function getDomainSingular():string {
            return $this->domainSingular;
        }

        /**
         * Returns related factory name
         *
         * @return string
         */
        public function getFactoryName():string {
            return $this->factoryName;
        }

        /**
         * Returns translated version of domain name
         *
         * @return string
         */
        public function getTranslation():string {
            return $this->translation;
        }

        /**
         * Returns clause version of domain name
         *
         * @return string
         */
        public function getTranslationClause():string {
            return $this->translationClause;
        }
    }