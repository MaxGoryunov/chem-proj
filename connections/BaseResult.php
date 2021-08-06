<?php

namespace Connections;

/**
 * Database query result with basic functionality.
 */
final class BaseResult implements Result
{

    /**
     * Ctor.
     * 
     * @param mixed $origin
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
     * {@inheritdoc}
     * @throws MethodNotFoundException if origin does not have this method.
     */
    public function fetchAssoc(): array
    {
        return $this->origin->{
            $this->redirections[__FUNCTION__] ??
            throw new MethodNotFoundException(
                sprintf(
                    "Method %s was not found in list of allowed methods: [%s]",__FUNCTION__,
                    implode(", ", $this->redirections)
                )
            )
        }();
    }
}
