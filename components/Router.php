<?php

	/**
	 * Class for providing routing within the site
	 */
    class Router {
		/**
		 * Routes for controller actions
		 *
		 * @var string[][]
		 */
        private $routes;

		/**
		 * Constructor assigns the routes to the inner routes property
		 */
        public function __construct() {
			include_once("./config/routes.php");
			
			$this->routes = $routes;
        }

		/**
		 * @todo Extract the calling of controller action into another method
		 */
		/**
		 * This function looks finds the controller using the routes and executes the associated action
		 *
		 * @return void
		 */
        public function run():void {
			$userUri = $_SERVER['REQUEST_URI'];

			/**
			 * @todo Implement a more efficient algorithm as this works for O(n) where n is the overall number of patterns
			 */
			foreach ($this->routes as $factory => $patterns) {
				foreach ($patterns as $pattern => $action) {
					$completePattern = ROOT . $pattern;
                    
					if (preg_match("~$completePattern$~", $userUri, $matches)) {
						/**
						 * Id of the specified item
						 * 
						 * If the id of some item is specified in the URL then it is contained in the first submask
						 * 
						 * @var string $id
						 */
						$id = $matches[1] ?? '';

						/**
						 * Factory used for creating MVCPDM components
						 * 
						 * @var IMVCPDMFactory
						 */
						$factoryObj = new $factory();

						$proxyController = $factoryObj->getProxy();

						if ($id) {
							$proxyController->$action($id);
						} else {
							$proxyController->$action();
						}
					}
				}
			}
        }
    }