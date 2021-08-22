<?php

namespace Http;

/**
 * HTTP response.
 */
interface Response
{

    /**
     * Converts response to string.
     *
     * @return string
     */
    public function toString(): string;
}
