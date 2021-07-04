<?php

namespace Domains;

interface Domain {

    /**
     * Returns domain singular and plural forms
     *
     * @return string[]
     */
    public function forms(): array;
}