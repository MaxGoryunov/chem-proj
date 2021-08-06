<?php

namespace Connections;

use Connections\MethodNotFoundException;

/**
 * Simple Redirection class.
 */
final class BaseResult implements Result
{

    /**
     * Ctor.
     * 
     * @param mixed                 $origin       original object.
     * @param array<string, string> $redirections map of method redirections.
     */
    public function __construct(
        /**
         * Original object.
         * 
         * @var mixed
         */
        private mixed $origin,
        
        /**
         * Map of method redirections.
         * 
         * @var array<string, string>
         */
        private array $redirections
    ) {
    }

    /**
     * {@inheritDoc}
     * @throws MethodNotFoundException if target method is not found.
     */
    public function __call(string $method, array $args): mixed
    {
        return $this->origin->{
            $this->redirections[$method] ??
            throw new MethodNotFoundException(
                sprintf(
                    "Method %s was not found in list of allowed methods: [%s]",__FUNCTION__,
                    implode(", ", $this->redirections)
                )
            )
        }();
    }
}
