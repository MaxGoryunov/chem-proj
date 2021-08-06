<?php

namespace Components;

/**
 * Current page in browser.
 */
final class CurrentPage
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
        return explode(
            "=",
            end(explode("/", $this->uri))
        ) ?? 1;
    }
}
