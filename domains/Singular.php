<?php

namespace Domains;

/**
 * Domain name in singular form
 */
class Singular extends FormEnvelope
{

    /**
     * {@inheritDoc}
     */
    public function __construct(string $domain)
    {
        parent::__construct($domain, "singular");
    }
}
