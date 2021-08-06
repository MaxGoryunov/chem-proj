<?php

    namespace Factories;
    
    /**
     * Base class for implementing other Factories
     */
    abstract class AbstractMVCPDMFactory implements IModelFactory, IViewFactory, IControllerFactory, IProxyFactory, IDataMapperFactory, IDomainFactory {
        
        /**
         * Returns domain string.
         *
         * @return string
         */
        public abstract function domainString(): string;
    }
