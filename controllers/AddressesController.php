<?php

    namespace Controllers;

    use Factories\UsersFactory;

    /**
     * Class contains Address Controller logic
     */
    class AddressesController extends AbstractController {

        /**
         * {@inheritDoc}
         */
        protected function paramsList():array {
            return [
                "name" => "string"
            ];
        }
    }