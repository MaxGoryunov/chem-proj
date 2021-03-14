<?php

    namespace Controllers;

    use Models\ConnectsModel;
    use Models\UsersModel;
    use mysqli;

    class UsersController extends AbstractController {

        /**
         * {@inheritDoc}
         */
        protected function getModel():UsersModel {
            return parent::getModel();
        }

        public function index():void {
            
        }

        public function edit(int $id):void {
            
        }

        public function add():void {
            
        }

        public function delete(int $id):void {
            
        }

        /**
         * Controls the user registration
         *
         * @return void
         */
        public function register():void {
            $title          = "Регистрация";
			$fullUserStatus = $this->getModel()->getUserAdminStatus();

			if ((isset($_POST["login"])) && (isset($_POST["password"])) && (isset($_POST["repeat_password"]))) {
                $login          = $_POST["login"];
                $password       = $_POST["password"];
                $repeatPassword = $_POST["repeat_password"];

                if ($password !== $repeatPassword) {
                    $this->getModel()->addInputError("repeat_password", "Password and repeated password must be the same");
                } else {
                    $registeredCount = $this->getModel()->calculateRegisteredCount($login);
					
					if ($registeredCount === 0) {
                        $name    = $_POST["name"];
                        $surname = $_POST["surname"];
                        $email   = $_POST["email"];
                        $phone   = $_POST["phone"];

                        $data = compact("name", "surname", "login", "email", "phone", "password");

                        session_start();
                        
						$sessionId = session_id();
                        
                        $_SESSION["id"]    = $this->getModel()->add($data)->insert_id;
                        $_SESSION["token"] = $this->getModel()->generateUserToken();

                        $time = time() + 15 * 60;
                        
                        $connectionData          = compact("id", "sessionId", "time");
                        $connectionData["token"] = $_SESSION["token"];

                        (new ConnectsModel())->add($connectionData);

						header("Location: ../medicines/list");
					} else { 
						$this->getModel()->addInputError("form", "This user already exists");
					}
				
				}
			}
		
			$this->getView()->render(__FUNCTION__, []);
        }

        /**
         * AUthorise user
         *
         * @return void
         */
        public function authorise():void {
            $title          = "Авторизация";
			$fullUserStatus = $this->getModel()->getUserAdminStatus();

			if ((isset($_POST["email"])) && (isset($_POST["password"]))) {
				$email          = $_POST["email"];
				$password       = $_POST["password"];

				$userInfo = $this->getModel()->getUserInfoByRegistrationData($email, $password);
				
				if ($userInfo["count"] == 1) {  
					$userId = $userInfo["user_id"];
					
					session_start();

					$sessionId = session_id();
                    $token     = $this->getModel()->generateUserToken();

                    $_SESSION["id"]    = $userId;
                    $_SESSION["token"] = $token;

					$unixTime = "FROM_UNIXTIME(" . (time() + 15 * 60) . ")";

					$connectionData = compact("token", "userId", "sessionId", "unixTime");

                    (new ConnectsModel())->add($connectionData);

					header("Location: ../medicines/list");
				} else {
					$this->getModel()->addInputError("form", "Incorrect login or password");
				}
			}

			$this->getView()->render(__FUNCTION__, []);
        }

        /**
         * Logs the user out of the system
         *
         * @return void
         */
        public function logout():void {
            $userId = $_SESSION["id"];

            $this->getModel()->deleteUserVariables($_SESSION);

            (new ConnectsModel())->delete($userId);

            header("Location: ../medicines/list");
        }
    }