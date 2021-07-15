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
     * File with domains.
     * 
     * @var string
     */
    private string $file;

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
     * @param string $file
     * @param string $form
     */
    public function __construct(string $domain, string $file, string $form)
    {
        $this->domain = $domain;
        $this->file   = $file;
        $this->form   = $form;
    }

    /**
     * Returns domain name in singular form
     *
     * @return string
     */
    public function value(): string
    {
        return (include ("./{$this->file}.php"))[$this->domain][$this->form];
    }
}
