<?php

	namespace Components;

	use InvalidArgumentException;
use LogicException;

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
		 * Assigns the routes for routing
		 *
		 * @param string[][] $routes
		 * @return void
		 */
		public function setRoutes(array $routes = []):void {
			$this->routes = $routes;
		}

		/**
		 * This function looks finds the controller using the routes and executes the associated action
		 *
		 * @return void
		 */
        public function run(string $userUri = ""):void {
			if ($userUri === "") {
				throw new InvalidArgumentException("User URI must not be empty");
			}

			if (!isset($this->routes)) {
				throw new LogicException("Routes are not set");
			}

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
						$id         = $matches[1] ?? "";
						$invokeData = compact("factory", "action", "id");

						$this->invokeFactory($invokeData);
					}
				}
			}
		}
		
		/**
		 * Creates factory and invokes its Proxy Controller method
		 *
		 * @param string[] $invokeData
		 * @return void
		 */
		protected function invokeFactory(array $invokeData = []):void {
			extract($invokeData);

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