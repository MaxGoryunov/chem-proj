<?php

namespace Routing;

use InvalidArgumentException;

/**
 * Protective router for cases when an empty string is given.
 */
final class NonEmptyRouter implements Router
{

    /**
     * Ctor.
     * 
     * @param Router $origin original router.
     */
    public function __construct(
        /**
         * Original router.
         *
         * @var Router
         */
        private Router $origin
    ) {
    }

    /**
     * {@inheritDoc}
     * @throws InvalidArgumentException if uri is empty.
     */
    public function run(string $uri): void
    {
        if ($uri === "") {
            throw new InvalidArgumentException(
                "Uri must not be empty"
            );
        }
        $this->origin->run($uri);
    }
}
