<?php

	namespace Components;

	use Components\RoutePackage;
	use ControllerActions\ControllerAction;
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
		 * This function looks finds the controller using the routes and executes the associated action
		 * 
		 * @throws InvalidArgumentException if the URI  is empty
		 *
		 * @return void
		 */
        public function run(string $userUri = ""):void {
			if ($userUri === "") {
				throw new InvalidArgumentException("User URI must not be empty");
			}

			$handler = new FactoryHandler();

			$handler->setNextHandler(new ActionHandler())->setNextHandler(new IdHandler());

			$action = $handler->handle(explode("/", $userUri), new ControllerAction());
			
			$action->execute();
		}

		/**
		 * Routing mechanism used for redirection of faulty routes
		 * 
		 * @todo Put this method into a different class or make it non-static
		 *
		 * @param string $location - URI where the user is redirected
		 * @return void
		 */
		public static function headerTo(string $location):void {
			header("Location: " . $location);
		}
    }
