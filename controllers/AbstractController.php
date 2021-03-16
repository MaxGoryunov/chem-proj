<?php

    namespace Controllers;

    use Components\DomainRegistry;
    use Factories\AbstractMVCPDMFactory;
    use Factories\UsersFactory;
    use Models\AbstractModel;
    use Models\DomainModel;
    use Views\AbstractView;

    /**
     * Base class for implementing other Controllers
     */
    abstract class AbstractController {
        
        /**
         * Related Factory used to get other components of MVCPDM structure
         *
         * @var AbstractMVCPDMFactory
         */
        protected $relatedFactory;

        /**
         * Related Model containing the business logic
         *
         * @var AbstractModel
         */
        protected $relatedModel;

        /**
         * Related View containing the presentation logic
         *
         * @var AbstractView
         */
        protected $relatedView;

        /**
         * Accepts the Factory to delegate it the creation of MVCPDM components
         *
         * @param AbstractMVCPDMFactory $relatedFactory
         */
        public function __construct(AbstractMVCPDMFactory $relatedFactory) {
            $this->relatedFactory = $relatedFactory;
        }

        /**
         * Returns a list of parameters needed for the model
         *
         * @return array<string, string>
         */
        protected abstract function paramsList():array;

        /**
         * Returns a related Model
         * 
         * Access to the Model is done in lazy load manner so that it is not created each time a query is made
         *
         * @return AbstractModel
         */
        protected function getModel():DomainModel {
            if (!isset($this->relatedModel)) {
                $this->relatedModel = $this->relatedFactory->getModel();
            }

            return $this->relatedModel;
        }

        /**
         * Returns a related View
         * 
         * Access to the View is done in lazy load manner so that it is not created each time a query is made
         *
         * @return AbstractView
         */
        protected function getView():AbstractView {
            if (!isset($this->relatedView)) {
                $this->relatedView = $this->relatedFactory->getView();
            }

            return $this->relatedView;
        }

        /**
         * Controls the presentation process of the Addresses from the DB
         *
         * @return void
         */
        public function index():void {
            $title        = $this->relatedFactory->getDomain()->getDomainPlural();
            $adminStatus  = (new UsersFactory())->getModel()->getUserAdminStatus();
            $count        = $this->getModel()->calculateRecordCount();
            $pageNumber   = $this->getModel()->getCurrentPageNumber($_SERVER["REQUEST_URI"]);
            $limit        = 5;
            $offset       = ($pageNumber - 1) * $limit;
            $entitiesList = $this->getModel()->getList($limit, $offset);

            $viewData = compact("title", "adminStatus", "entitiesList");

            $this->getView()->render(__METHOD__, $viewData);
        }

        /**
         * {@inheritDoc}
         */
        public function edit(int $id):void {
            $title       = "Редактирование " . $this->relatedFactory->getDomain()->getTranslationClause();
            $entity      = $this->getModel()->getById($id);
            $adminStatus = (new UsersFactory())->getModel()->getUserAdminStatus();
			$paramsList  = $this->paramsList();

			if ($this->getModel()->paramsExist($_POST, $paramsList)) {
                $data["id"] = $id;

                foreach ($paramsList as $name => $type) {
                    $data[$name] = $_POST[$name];
                }

                $this->getModel()->edit($data);
            }
            
            $viewData =  compact("title", "entity", "adminStatus");
            
            $this->getView()->render(__FUNCTION__, $viewData);
        }
    }