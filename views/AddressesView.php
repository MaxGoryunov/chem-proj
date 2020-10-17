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
            extract($data);
            
            $filePath = "./templates/";

            if ($template == "index") {
                $filePath .= "common/";
            } else {
                $filePath .= "addresses/";
            }

            $filePath .= $template . ".php";

            if (file_exists($filePath)) {
                include_once($filePath);
            }
        }
    }