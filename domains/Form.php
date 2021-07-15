<?php

namespace Domains;

interface Form
{

    /**
     * Returns a domain name in some form
     *
     * @return string
     */
    public function value(): string;
}