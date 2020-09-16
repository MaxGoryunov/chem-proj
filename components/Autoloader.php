<?php

	namespace Components;

	use Closure;

	/**
	 * Class for autoloading classes, interfaces or traits
	 */
	class Autoloader {

		/**
		 * Registers an autoloader function
		 *
		 * @return void
		 */
		public function register(Closure $autoloader = null):void {
			if (isset($autoloader)) {
				spl_autoload_register($autoloader);
				return;
			}
			if (in_array("spl_autoload", $this->getAutoloaders())) {
				return;
			}
			
			spl_autoload_extensions(".php");
			spl_autoload_register();
		}

		/**
		 * Returns registered autoloaders
		 *
		 * @return (string|Closure)[]
		 */
		public function getAutoloaders():array {
			$autoloaders = spl_autoload_functions();

			if (!$autoloaders) {
				return [];
			}

			return $autoloaders;
		}

		/**
		 * Removes a function from the autoloaders function stack
		 *
		 * @return void
		 */
		public function unregister(Closure $autoloader = null):void {
			if (!isset($autoloader)) {
				spl_autoload_unregister("spl_autoload");
			}

			spl_autoload_unregister($autoloader);
		}
		
	}
