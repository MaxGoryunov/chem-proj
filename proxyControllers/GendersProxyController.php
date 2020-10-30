<?php

    namespace ProxyControllers;

    /**
     * Class which replaces GendersController on class calls
     */
    class GendersProxyController extends AbstractProxyController {
        
        /**
         * {@inheritDoc}
         */
        public function index():void {
            $this->getController()->index();
        }

        /**
         * {@inheritDoc}
         */
        public function add():void {
            
        }

        /**
         * {@inheritDoc}
         */
        public function edit(int $id):void {
            
        }

        /**
         * {@inheritDoc}
         */
        public function delete(int $id):void {
            
        }
    }