<?php

    namespace Controllers;

    use Factories\UsersFactory;

    /**
     * Class contains User Status Controller logic
     */
    class UserStatusesController extends AbstractController {

        /**
         * {@inheritDoc}
         */
        protected function paramsList():array {
            return [
                "name" => "string"
            ];
        }
    }