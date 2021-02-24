<?php

    namespace ProxyControllers;

    use Models\ConnectsModel;

    /**
     * Protects UsersController actions
     */
    class UsersProxyController extends AbstractProxyController {

        /**
         * Protects 'logout' action
         * 
         * Is does not allow user to log out if they have not been authorised yet
         *
         * @return void
         */
        public function logout():void {
            $isAuthorised = (new ConnectsModel())->getUserAuthStatus($_SESSION["id"], $_SESSION["token"], session_id());

            if ($isAuthorised) {
                $this->getController()->logout();
            } else {
                header("Location: " . SITE_ROOT . "errors/not_authorised");
            }
        }
    }