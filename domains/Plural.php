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
    public function __construct(string $domain)
    {
        parent::__construct($domain, "plural");
    }
}
