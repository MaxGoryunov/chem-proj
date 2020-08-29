<?php

	/**
	 * Class for autoloading classes, interfaces or traits
	 */
	class Autoloader {
		/**
		 * Directories in which the class, interface or trait file is present
		 *
		 * @var string[]
		 */
		private $dirs = [];
		
		/**
		 * The initialization of the directories array is done in Lazy Load manner in order not to waste time resources
		 *
		 * @return void
		 */
		private function initDirs():void {
			if (empty($this->dirs)) {
                $this->dirs = array("components", "controllers", "models", "views", "dbQueries", "traits");
            }
		}

		public function register():void {
			$this->initDirs();

			/**
			 * @todo Implement a more effective way of class loading and then test it; maybe with the Regex Expressions
			 */
			/**
			 * Anonymous function
			 * 
			 * @param string $className - name of the class to be included
			 * 
			 * @return void
			 */
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
