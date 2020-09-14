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
			if (in_array("spl_autoload", $this->getAutoloaders())) {
				return;
			}
			
			spl_autoload_extensions(".php");
			spl_autoload_register();
		}

		/**
		 * Returns registered autoloaders
		 *
		 * @return callback[]|bool
		 */
		public function getAutoloaders() {
			return spl_autoload_functions();
		}

		public function unregister():void {
			spl_autoload_unregister("spl_autoload");
		}
	}
