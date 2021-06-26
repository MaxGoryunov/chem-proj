<?php

    namespace Views;
    
    /**
     * Base class for implementing other Views
     */
    class DomainView implements IView {

        /**
         * Domain to which the view belongs
         *
         * @var string
         */
        private $domain;

        /**
         * @param string $domain
         */
        public function __construct(string $domain) {
            $this->domain = $domain;
        }

        /**
         * {@inheritDoc}
         */
        public function render(string $template, array $data = []):void {
            extract($data);

            include("./$domain/$template.php");
        }
    }