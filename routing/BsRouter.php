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
	 * Ctor.
	 * 
	 * @param array<string, Endpoint> $endpoints list of available endpoints.
	 */
	public function __construct(
		/**
		 * List of available endpoints.
		 *
		 * @var array<string, Endpoint>
		 */
		private array $endpoints
	) {
	}

	/**
	 * {@inheritDoc}
	 */
	public function run(string $uri): void
	{
		
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
