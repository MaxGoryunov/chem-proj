<?php

	class Autoloader {

		public static function register() {
			spl_autoload_register(function(string $className):void {
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
