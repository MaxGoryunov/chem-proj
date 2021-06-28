<?php

    namespace Views;
    
    /**
     * Interface specifies common View methods
     */
    interface IView {

        /**
         * Renders a supplied template based on the extracted data
         *
         * @param string $template - template for rendering, lies in the ./templates folder
         * @param array  $data     - data for rendering, supposed to be compacted with compact() function
         * @return void
         */
        public function render(string $template, array $data = []):void;
    }