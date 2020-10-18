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

			return (array)$autoloaders;
		}

		/**
		 * Removes a function from the autoloaders function stack
		 * 
		 * Note: spl_autoload cannot be unregistered
		 *
		 * @return void
		 */
		public function unregister(Closure $autoloader = null):void {
			if (!isset($autoloader)) {
				return;
			}

			spl_autoload_unregister($autoloader);
		}
		
	}
