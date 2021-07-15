<?php

namespace Domains;

/**
 * Domain name in plural form
 */
class Plural extends FormEnvelope
{

    /**
     * {@inheritDoc}
     */
    public function __construct(string $domain, string $file)
    {
        parent::__construct($domain, $file, "plural");
    }
}
