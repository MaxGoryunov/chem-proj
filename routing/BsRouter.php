<?php

namespace Routing;

use ControllerActions\ControllerAction;
use InvalidArgumentException;
use Routing\ActionHandler;
use Routing\FactoryHandler;
use Routing\IdHandler;

/**
 * Class for providing routing within the site
 */
class BsRouter implements Router
{

	/**
	 * {@inheritDoc}
	 */
	public function run(string $uri): void
	{
		if ($uri === "") {
			throw new InvalidArgumentException("User URI must not be empty");
		}

		$handler = new FactoryHandler();

		$handler->setNextHandler(new ActionHandler())->setNextHandler(new IdHandler());

		$action = $handler->handle(explode("/", $uri), new ControllerAction());

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
	public static function headerTo(string $location): void
	{
		header("Location: " . $location);
	}
}
