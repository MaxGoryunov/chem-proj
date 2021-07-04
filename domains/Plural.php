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
    public function __construct(Domain $domain)
    {
        parent::__construct($domain, "plural");
    }
}
