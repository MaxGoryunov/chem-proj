<?php

	class Autoloader {
		private $dirs = [];
		
		private function initDirs():void {
			if (empty($this->dirs)) {
                $this->dirs = array("components", "controllers", "models", "views");
            }
		}

		public function register():void {
			$this->initDirs();
			
			spl_autoload_register(function(string $className):void {
				foreach ($this->dirs as $dir) {
					$filePath = "./$dir/$className.php";
					
					if (file_exists($filePath)) {
						include_once($filePath);
		
						break;
					}
				}
			});
		}
	}
