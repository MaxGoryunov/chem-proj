<?php

    namespace Factories;

    use Views\IView;

    /**
     * Interface for Factories which can create Views
     */
    interface IViewFactory {

        /**
         * Returns a specified View
         *
         * @return IView
         */
        public function getView():IView;
    }