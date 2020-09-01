<?php

    /**
     * Base class for implementing other Controllers
     */
    abstract class AbstractController implements IController {
        
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
         * Accepts the Factory to delegate it the creation of other Factories
         *
         * @param IMVCPDMFactory $relatedFactory
         */
        public function __construct(IMVCPDMFactory $relatedFactory) {
            $this->relatedFactory = $relatedFactory;
        }
    }