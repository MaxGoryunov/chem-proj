<?php

namespace UI\Components;

use UI\Component;

/**
 * Sidebar for all pages.
 */
final class Sidebar implements Component
{

    /**
     * Ctor.
     * 
     * @param string[] $links links to other pages.
     */
    public function __construct(
        /**
         * Links to other pages.
         *
         * @var string[]
         */
        private array $links
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function rendered(): string
    {
        ob_start();
        include "./ui/templates/sidebar.php";
        return ob_get_clean();
    }
}
