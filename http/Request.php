<?php

namespace Http;

/**
 * Request interface.
 */
interface Request
{

    /**
     * Method name.
     *
     * @return string
     */
    public function method(): string;

    /**
     * Returns a storage based on the given name.
     *
     * @param string $name
     * @return array<mixed>
     */
    public function storage(string $name): array;

    /**
     * Page URI.
     *
     * @return string
     */
    public function uri(): string;
}
