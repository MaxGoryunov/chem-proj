<?php

    namespace Controllers;

    use Factories\UsersFactory;

    /**
     * Class contains Address Controller logic
     */
    class AddressesController extends AbstractController {
        
        /**
         * Controls the presentation process of the Addresses from the DB
         *
         * @return void
         */
        public function index():void {
            $title             = "Адреса";
            $fullUserStatus    = (new UsersFactory())->getModel()->getUserFullStatus();
            $addressesCount    = $this->getModel()->calculateRecordCount();
            $currentPageNumber = $this->getModel()->getCurrentPageNumber();
            $limit             = 5;
            $offset            = ($currentPageNumber - 1) * $limit;
            $addressesList     = $this->getModel()->getList($limit, $offset);

            $viewData = array_merge($fullUserStatus, compact("title", "addressesList"));

            $this->getView()->render(__METHOD__, $viewData);
        }

        /**
         * Controls the editing process of an Address based on id
         *
         * @param int $id - id of the Address to be edited
         * @return void
         */
        public function edit(int $id):void {
            $title          = "Редактирование адреса";
            /**
             * @todo Might have to move address instantiation below if statement
             */
            $address        = $this->getModel()->getById($id);
            $fullUserStatus = (new UsersFactory())->getModel()->getUserFullStatus();
			
			if (isset($_POST["name"])) {
				$name = $_POST["name"];
				$id   = $id;
                $data = compact("name", "id");
                
                $this->getModel()->edit($data);
            }
            
            $viewData = array_merge($fullUserStatus, compact("title", "address"));
            
            $this->getView()->render(__FUNCTION__, $viewData);
        }

        /**
         * Controls the creation of an Address
         *
         * @return void
         */
        public function add():void {
            $title          = "Добавление адреса";
			$fullUserStatus = (new UsersFactory())->getModel()->getUserFullStatus();
			
			if (isset($_POST["name"])) {
				$name = $_POST["name"];
                $data = compact("name");

                $this->getModel()->add($data);
			}

            $viewData = array_merge($fullUserStatus, compact("title"));
            
			$this->getView()->render(__FUNCTION__, $viewData);
        }

        /**
         * Controls the deletion process of an Address based on id
         *
         * @param int $id - id of the Address to be deleted
         * @return void
         */
        public function delete(int $id):void {
            $title = "Удаление адреса";
            $address = $this->getModel()->getById($id);
            $fullUserStatus = (new UsersFactory())->getModel()->getUserFullStatus();

            if (isset($_POST["delete"])) {
                $this->getModel()->delete($id);
            }

			header('Location: ../list');
        }
    }