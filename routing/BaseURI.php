<?php

namespace Routing;

/**
 * Base URI implementation.
 */
final class BaseURI implements URI
{

    /**
     * Ctor.
     * 
     * @param string $uri raw URI.
     */
    public function __construct(
        /**
         * Raw URI.
         * 
         * @var string
         */
        private string $uri
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function parted(): array
    {
        return preg_split("~[\\\/]~", $this->uri);
    }

    /**
     * {@inheritDoc}
     */
    public function count(): int
    {
        return preg_match_all("/[\\\/]/", $this->uri);
    }
}
