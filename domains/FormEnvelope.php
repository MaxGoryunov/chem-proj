<?php

namespace Domains;

abstract class FormEnvelope implements Form
{

    /**
     * Current domain
     * 
     * @var string
     */
    private string $domain;

    /**
     * Form of domain name
     * 
     * @var string
     */
    private string $form;

    /**
     * Ctor.
     *
     * @param string $domain
     * @param string $form
     */
    public function __construct(string $domain, string $form)
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
        return include ("./config/domainData.php")[$this->domain][$this->form];
    }
}
