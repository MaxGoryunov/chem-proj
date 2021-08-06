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
    public function __construct(string $domain, string $file)
    {
        parent::__construct($domain, $file, "singular");
    }
}
