<?php

    namespace Controllers;

    use Factories\AbstractMVCPDMFactory;
    use Factories\UsersFactory;
    use Models\AbstractModel;
    use Models\DomainModel;
    use Models\UsersModel;
    use Views\DomainView;

/**
     * Base class for implementing other Controllers
     */
    class DomainController implements IController {

        /**
         * Contains requirements for post variables
         * 
         * @var array<string, string[]>
         */
        private const REQUIREMENTS = [
            "addresses"     => ["name"],
            "genders"       => ["name", "short_name"],
            "user_statuses" => ["name"]
        ];

        /**
         * Domain to which the controller belongs
         *
         * @var string
         */
        private $domain = "";

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
         * @param AbstractMVCPDMFactory $relatedFactory - factory which creates required components
         * @param string                $domain         - domain name
         */
        public function __construct(AbstractMVCPDMFactory $relatedFactory, string $domain) {
            $this->relatedFactory = $relatedFactory;
            $this->domain         = $domain;
        }

        /**
         * Returns a list of parameters needed for the model
         * 
         * @todo Refactor useless string keys
         *
         * @return string[]
         */
        protected function paramsList():array {
            return self::REQUIREMENTS[$this->domain] ?? [];
        }

        /**
         * Returns a related Model
         * 
         * Access to the Model is done in lazy load manner so that it is not created each time a query is made
         *
         * @return AbstractModel|UsersModel
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
        protected function getView():DomainView {
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
            $limit        = 5;

            $this->getView()->render(
                __METHOD__, 
                [
                    "title"        => $this->relatedFactory->getDomain()->getDomainPlural(),
                    "adminStatus"  => (new UsersFactory())->getModel()->getUserAdminStatus(),
                    "count"        => $this->getModel()->calculateRecordCount(),
                    "entitiesList" => $this->getModel()->getList(
                        $limit, 
                        $limit * (
                            $this->getModel()->getCurrentPageNumber($_SERVER["REQUEST_URI"]) - 1
                        )
                    )
                ]
            );
        }

        /**
         * {@inheritDoc}
         */
        public function add():void {
            $paramsList  = $this->paramsList();
			
			if ($this->getModel()->paramsExist($_POST, $paramsList)) {
                foreach ($paramsList as $name => $type) {
                    $data[$name] = $_POST[$name];
                }

                $this->getModel()->add($data);
			}

			$this->getView()->render(
                __FUNCTION__, 
                [
                    "title"       => "Добавление " . $this->relatedFactory->getDomain()->getTranslationClause(),
                    "adminStatus" => (new UsersFactory())->getModel()->getUserAdminStatus(),
    
                ]
            );
        }

        /**
         * {@inheritDoc}
         */
        public function edit(int $id):void {
			$paramsList  = $this->paramsList();

			if ($this->getModel()->paramsExist($_POST, $paramsList)) {
                $data["id"] = $id;

                foreach ($paramsList as $name => $type) {
                    $data[$name] = $_POST[$name];
                }

                $this->getModel()->edit($data);
            }

            $this->getView()->render(
                __FUNCTION__, 
                [
                    "title"       => "Редактирование " . $this->relatedFactory
                                                        ->getDomain()
                                                        ->getTranslationClause(),
                    "entity"      => $this->getModel()->getById($id),
                    "adminStatus" => (new UsersFactory())->getModel()->getUserAdminStatus()
                ]
            );
        }

        
        /**
         * {@inheritDoc}
         */
        public function delete(int $id):void {
            if (isset($_POST["delete"])) {
                $this->getModel()->delete($id);
            }

            $this->getView()->render(
                __FUNCTION__,
                [
                    "title"       => "Удаление " . $this->relatedFactory->getDomain()->getTranslationClause(),
                    "entity"      => $this->getModel()->getById($id),
                    "adminStatus" => (new UsersFactory())->getModel()->getUserAdminStatus()
                ]
            );
        }
    }