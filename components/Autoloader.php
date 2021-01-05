<?php

	namespace Components;

	use Closure;

	/**
	 * Class for autoloading classes, interfaces or traits
	 */
	class Autoloader {

		
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
		 * Registers an autoloader function
		 *
		 * @return void
		 */
		public function register():void {
			spl_autoload_extensions(".php");
			spl_autoload_register();
		}

		/**
		 * Registers user's autoloader function
		 *
		 * @param Closure $autoloader
		 * @return void
		 */
		public function registerUserAutoloader(Closure $autoloader):void {
			spl_autoload_register($autoloader);
		}

		/**
		 * Removes a function from the autoloaders function stack
		 * 
		 * Note: spl_autoload cannot be unregistered
		 *
		 * @return void
		 */
		public function unregisterUserAutoloader(Closure $autoloader = null):void {
			if (!isset($autoloader)) {
				return;
			}

			spl_autoload_unregister($autoloader);
		}
		
	}
