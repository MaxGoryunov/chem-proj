<?php

namespace Domains;

abstract class FormEnvelope
{

    /**
     * Current domain
     * 
     * @var Domain
     */
    private Domain $domain;

    /**
     * Form of domain name
     * 
     * @var string
     */
    private string $form;

    /**
     * Ctor.
     *
     * @param Domain $domain
     */
    public function __construct(Domain $domain, string $form)
    {
        $this->domain = $domain;
        $this->form   = $form;
    }

    /**
     * Returns domain name in singular form
     *
     * @return string
     */
    public function value(): string
    {
        return $this->domain->forms()[$this->form];
    }
}
