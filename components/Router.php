<?php

	namespace Components;

	use Components\RoutePackage;
	use InvalidArgumentException;
	use LogicException;
use Routing\ActionHandler;
use Routing\FactoryHandler;
use Routing\IdHandler;

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
		 * Contains route packages for controller actions
		 *
		 * @var RoutePackage[]
		 */
		private $routePackages;
		
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
		 * Assigns route packages for routing
		 *
		 * @param RoutePackage[] $routePackages
		 * @return void
		 */
		public function setRoutePackages(array $routePackages):void {
			foreach ($routePackages as $routePackage) {
				$this->routePackages[$routePackage->getDomain()] = $routePackage;
			}
		}

		/**
		 * This function looks finds the controller using the routes and executes the associated action
		 * 
		 * @throws InvalidArgumentException
		 * @throws LogicException
		 *
		 * @return void
		 */
        public function run(string $userUri = ""):void {
			if ($userUri === "") {
				throw new InvalidArgumentException("User URI must not be empty");
			}

			// if (!isset($this->routes)) {
			// 	throw new LogicException("Routes are not set");
			// }

			$handler = new FactoryHandler();

			$handler->setNextHandler(new ActionHandler())->setNextHandler(new IdHandler());

			$invokeData = $handler->handle(explode("/", $userUri));

			$this->invokeFactory($invokeData);
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

		/**
		 * Routing mechanism used for redirection of faulty routes
		 *
		 * @param string $location - URI where the user is redirected
		 * @return void
		 */
		public static function headerTo(string $location):void {
			header("Location: " . $location);
		}
    }