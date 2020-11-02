<?php

    namespace Controllers;

    use Factories\AbstractMVCPDMFactory;
    use Models\AbstractModel;
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
         * Returns a related Model
         * 
         * Access to the Model is done in lazy load manner so that it is not created each time a query is made
         *
         * @return AbstractModel
         */
        protected function getModel():AbstractModel {
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
    }