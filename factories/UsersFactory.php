<?php

    namespace Factories;

    use Models\UsersModel;

    /**
     * Class for creating components from Users domain
     */
    class UsersFactory {

        /**
         * Returns a Users Model
         *
         * @return UsersModel
         */
        public function getModel():UsersModel {
            return new UsersModel();
        }

    }