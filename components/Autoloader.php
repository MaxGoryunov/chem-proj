<?php

	class Autoloader {

		public static function register():void {
			spl_autoload_register(function(string $className):void {
				/**
				 * Directories in which the class, interface or trait file is present
				 * 
				 * @var string[]
				 */
				$dirs = array("components", "controllers", "models", "views");
				
				foreach ($dirs as $dir) {
					$filePath = "./$dir/$className.php";
					
					if (file_exists($filePath)) {
						include_once($filePath);
		
						break;
					}
				}
			});
		}
	}
