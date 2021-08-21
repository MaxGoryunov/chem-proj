<?php

namespace Routing;

/**
 * A router.
 */
interface Router
{

    /**
     * Runs a route.
     *
     * @return void
     */
    public function run(string $uri): void;
}
