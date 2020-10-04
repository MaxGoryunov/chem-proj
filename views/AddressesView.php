<?php

    namespace Views;
    
    /**
     * Class for Address presentation logic
     */
    class AddressesView extends AbstractView {
        
        /**
         * {@inheritDoc}
         */
        public function render(string $template, array $data = []):void {
            echo "<pre>";

            print_r($data);
        }
    }