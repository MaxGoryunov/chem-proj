<?php

    /**
     * This interface is used primarily by ErrorsFactory as almost(or all, I cannot say for sure as this piece of code might be changed later) all the other factories will use Complete Interface
     * 
     * VC stands for View - Controller because only these two parts are used to generate Error Pages
     */
    interface IVCIncompleteFactory {
        /**
         * Returns a specified Controller
         *
         * @return AbstractController
         */
        public function getController():AbstractController;

        /**
         * Returns a specified View
         *
         * @return AbstractView
         */
        public function getView():AbstractView;
    }