<?php

namespace Components;

/**
 * Current page in browser.
 */
final class CurrentPage implements Scalar
{
    public function __construct(
        /**
         * Page URI.
         * 
         * @var string
         */
        private string $uri
    ) {
    }

    /**
     * Returns current page number.
     *
     * @return int
     */
    public function value(): int
    {
        preg_match(
            "/(page=)([1-9][0-9]*)/",
            explode("?", $this->uri)[1],
            $matches
        );
        return $matches[2];
    }
}
