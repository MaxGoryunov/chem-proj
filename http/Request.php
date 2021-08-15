<?php

namespace Http;

/**
 * Request interface.
 * @todo #103:30min Add Request implementation. Let's add a class which
 *  implements this interface.
 * @todo #103:20min Make `uri` method return URI object.
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
