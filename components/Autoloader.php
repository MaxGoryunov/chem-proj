<?php

	namespace Components;
	
	/**
	 * Class for autoloading classes, interfaces or traits
	 */
	class Autoloader {

		/**
		 * Registers an autoloader function
		 *
		 * @return void
		 */
		public function register():void {
			spl_autoload_extensions(".php");
			spl_autoload_register();
		}
	}
