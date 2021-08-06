<?php

namespace Controllers;

use Factories\UsersFactory;
use Fallbacks\Fallback;
use Models\UsersModel;

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
     * Model for checking user admin status.
     * 
     * @var UsersModel
     */
    private UsersModel $model;

    /**
     * Fallback if user is not an admin.
     * 
     * @var Fallback
     */
    private Fallback $fallback;

    /**
     * Ctor.
     *
     * @param IController $controller
     * @param UsersModel  $model
     * @param Fallback    $fallback
     */
    public function __construct(IController $controller, UsersModel $model, Fallback $fallback)
    {
        $this->origin   = $controller;
        $this->model    = $model;
        $this->fallback = $fallback;
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
        if ($this->model->getUserAdminStatus($_COOKIE["id"])) {
            $this->origin->add();
        } else {
            $this->fallback->call();
        }
    }

    /**
     * {@inheritDoc}
     */
    public function edit(int $id): void
    {
        if ($this->model->getUserAdminStatus($_COOKIE["id"])) {
            $this->origin->edit($id);
        } else {
            $this->fallback->call();
        }
    }

    /**
     * {@inheritDoc}
     */
    public function delete(int $id): void
    {
        if ($this->model->getUserAdminStatus($_COOKIE["id"])) {
            $this->origin->delete($id);
        } else {
            $this->fallback->call();
        }
    }
}
