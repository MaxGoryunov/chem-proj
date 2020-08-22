<?php

    class Router {
		/**
		 * Routes for controller actions
		 *
		 * @var string[][]
		 */
        private $routes;

        public function __construct() {
			include_once("./config/routes.php");
			
			$this->routes = $routes;
        }

        public function run():void {
			$userUri = $_SERVER['REQUEST_URI'];

			/**
			 * @todo Implement a more efficient algorithm as this works for O(n) where n is the overall number of patterns
			 */
            foreach ($this->routes as $controller => $patterns) {
				foreach ($patterns as $pattern => $action) {
                    $completePattern = ROOT . $pattern;
                    
					if (preg_match("~$completePattern$~", $userUri, $matches)) {
						/**
						 * If the id of some item is specified in the URL then it is contained in the first submask
						 * 
						 * @var string $id
						 */
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