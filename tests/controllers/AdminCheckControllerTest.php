<?php

namespace Tests\Controllers;

use Controllers\IController;
use Controllers\AdminCheckController;
use Fallbacks\Fallback;
use Models\IModel;
use Models\UsersModel;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass Controllers\AdminCheckController
 */
class AdminCheckControllerTest extends TestCase
{

    /**
     * @covers ::__construct
     * @covers ::index
     * 
     * @small
     *
     * @return void
     */
    public function testIndexInvokesInnerControllerMethod(): void
    {
        $origin = $this->getMockBuilder(IController::class)->getMock();
        $origin->expects($this->once())
        ->method("index");
        (new AdminCheckController(
            $origin,
            $this->getMockBuilder(UsersModel::class)
            ->disableOriginalConstructor()
            ->getMock(),
            $this->getMockBuilder(Fallback::class)->getMock()
        ))->index();
    }

    /**
     * @covers ::__construct
     * @covers ::add
     * 
     * @small
     * 
     * @runInSeparateProcess
     *
     * @return void
     */
    public function testInvokesAddIfUserIsAdmin(): void
    {
        $_COOKIE["id"] = 2;
        $origin = $this->getMockBuilder(IController::class)->getMock();
        $origin->expects($this->once())
        ->method("add");
        $model  = $this->getMockBuilder(UsersModel::class)
        ->disableOriginalConstructor()
        ->getMock();
        $model->expects($this->once())
        ->method("getUserAdminStatus")
        ->willReturn(true);
        (new AdminCheckController(
            $origin,
            $model,
            $this->getMockBuilder(Fallback::class)->getMock()
        ))->add();
    }

    /**
     * @covers ::__construct
     * @covers ::add
     * 
     * @small
     * 
     * @runInSeparateProcess
     *
     * @return void
     */
    public function testInvokesFallbackInAddIfUserIsNotAdmin(): void
    {
        $_COOKIE["id"] = 2;
        $model  = $this->getMockBuilder(UsersModel::class)
        ->disableOriginalConstructor()
        ->getMock();
        $model->expects($this->once())
        ->method("getUserAdminStatus")
        ->willReturn(false);
        $fallback = $this->getMockBuilder(Fallback::class)->getMock();
        $fallback->expects($this->once())
        ->method("call");
        (new AdminCheckController(
            $this->getMockBuilder(IController::class)->getMock(),
            $model,
            $fallback
            ))->add();
    }
}
