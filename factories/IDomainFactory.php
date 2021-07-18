<?php

    namespace Factories;

    use Components\Domain;

    /**
     * Factory interface for returning related domain
     */
    interface IDomainFactory {

        /**
         * Returns related domain
         *
         * @return Domain
         */
        public function getDomain():Domain;
    }
