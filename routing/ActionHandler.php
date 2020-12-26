<?php

    namespace Routing;

use Components\Router;
use ControllerActions\AddAction;
    use ControllerActions\DeleteAction;
    use ControllerActions\EditAction;
    use ControllerActions\IndexAction;
    use ControllerActions\RegisterAction;

    /**
     * Class for handling Actions in user URI
     */
    class ActionHandler extends AbstractHandler {

        /**
         * Contains allowed actions
         * 
         * @var string[]
         */
        private const ACTIONS = [
            "list"     => IndexAction::class,
            "add"      => AddAction::class,
            "edit"     => EditAction::class,
            "delete"   => DeleteAction::class,
            "register" => RegisterAction::class
        ];

        /**
         * {@inheritDoc}
         */
        protected function fillData(array $partedUri, array $invokeData = []):array {
            if (isset(self::ACTIONS[$partedUri[3]])) {
                $invokeData["action"] = self::ACTIONS[$partedUri[3]];

                return $invokeData;
            }

            Router::headerTo("./errors/not_found");

            return [];
        }
    }