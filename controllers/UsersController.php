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
                    /**
                     * @todo Implement error handling
                     */
                } else {
                    $registeredCount = $this->getModel()->calculateRegisteredCount($login);
					
					if ($registeredCount === 0) {
                        $name    = $_POST["name"];
                        $surname = $_POST["surname"];
                        $email   = $_POST["email"];
                        $phone   = $_POST["phone"];

                        $salt           = $this->getModel()->getSalt();
                        $hashedPassword = $this->getModel()->hashPassword($password, $salt);

                        $data = compact("name", "surname", "login", "email", "phone", "hashedPassword", "salt");

                        /**
                         * @todo Add 'add' method return type
                         * @var mysqli
                         */
                        $connection = $this->getModel()->add($data);
						$id         = $connection->insert_id;
						
                        session_start();
                        
						$sessionId = session_id();
						$token     = $this->getModel()->generateUserToken();
                        $tokenTime = time() + 15 * 60;
                        
                        $_SESSION["id"]    = $id;
                        $_SESSION["token"] = $token;

                        $unixTime = "FROM_UNIXTIME(" . $tokenTime . ")";
                        
                        $connectionData = compact("token", "id", "sessionId", "unixTime");

                        (new ConnectsModel())->add($connectionData);

						header("Location: ../medicines/list");
					} else { 
						/**
                         * @todo Implement error handling
                         */
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
				$userSalt       = $this->getModel()->getSaltByUserEmail($email);
				$hashedPassword = $this->getModel()->hashPassword($password, $userSalt);

				$userInfo = $this->getModel()->getUserInfoByRegistrationData($email, $hashedPassword);
				
				if ($userInfo["count"] == 1) {  
					$userId = $userInfo["user_id"];
					
					session_start();

					$sessionId = session_id();
                    $token     = $this->getModel()->generateUserToken();
					$tokenTime = time() + 15 * 60;

                    $_SESSION["id"]    = $userId;
                    $_SESSION["token"] = $token;

					$unixTime = "FROM_UNIXTIME(" . $tokenTime . ")";

					$connectionData = compact("token", "userId", "sessionId", "tokenTime");

                    (new ConnectsModel())->add($connectionData);

					header("Location: ../medicines/list");
				} else {
					echo ("Неправильно введен логин или пароль. Проверьте данные.");
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
            $userId = $_SESSION["user_id"];

            $this->getModel()->deleteUserVariables($_SESSION);

            (new ConnectsModel())->delete($userId);

            header("Location: ../medicines/list");
        }
    }