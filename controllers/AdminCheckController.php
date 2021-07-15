<?php

namespace Controllers;

/**
 * Protects inner controller from users without Admin status.
 */
class AdminCheckController implements IController
{

    /**
     * Original controller.
     * 
     * @var IController
     */
    private IController $origin;

    /**
     * Ctor.
     *
     * @param IController $controller
     */
    public function __construct(IController $controller)
    {
        $this->origin = $controller;
    }

    /**
     * {@inheritDoc}
     */
    public function index(): void
    {
        $this->origin->index();
    }

    /**
     * {@inheritDoc}
     */
    public function add(): void
    {
        
    }

    /**
     * {@inheritDoc}
     */
    public function edit(int $id): void
    {
        
    }

    /**
     * {@inheritDoc}
     */
    public function delete(int $id): void
    {
        
    }
}
