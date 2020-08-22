<?php

    class Router {
        private $routes;

        public function __construct() {
            include_once("./");
        }

        public function run():void {
            $userUri = $_SERVER['REQUEST_URI'];

            foreach ($this->routes as $controller => $patterns) {
				foreach ($patterns as $pattern => $action) {
                    $completePattern = ROOT . $pattern;
                    
					if (preg_match("~$completePattern$~", $userUri, $matches)) {

						$id = isset($matches[1]) ? $matches[1] : '';
						$controllerObj = new $controller();

						if ($id) {
							$controllerObj->$action($id);
						} else {
							$controllerObj->$action();
						}
						exit();
					}
				}
			}
        }
    }