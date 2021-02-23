<?php

    namespace Routing;

    use Components\Router;
    use ControllerActions\ControllerAction;
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
            "list"     => "index",
            "add"      => "add",
            "edit"     => "edit",
            "delete"   => "delete",
            "register" => "register"
        ];

        /**
         * {@inheritDoc}
         */
        protected function fillData(array $partedUri, ControllerAction $action):ControllerAction {
            $actionName = self::ACTIONS[$partedUri[3]] ?? null;

            if (isset($actionName)) {
                $action->setActionName($actionName);
            } else {
                Router::headerTo("./errors/not_found");
            }

            return $action;
        }
    }