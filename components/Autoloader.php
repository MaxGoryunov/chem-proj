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
		public function register(Closure $func = null):void {
			if (isset($func)) {
				spl_autoload_register($func);
				return;
			}
			
			spl_autoload_extensions(".php");
			spl_autoload_register();
		}

		/**
		 * Returns registered autoloaders
		 *
		 * @return callback[]
		 */
		public function getAutoloaders():array {
			return spl_autoload_functions();
		}
	}
