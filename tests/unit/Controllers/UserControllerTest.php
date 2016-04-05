<?php

use Fce\Http\Controllers\UserController;
use Fce\Http\Requests\UserRequest;
use Fce\Repositories\Contracts\UserRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Created by BrainMaestro
 * Date: 6/3/2016
 * Time: 12:35 AM.
 */
class UserControllerTest extends TestCase
{
    protected $request;
    protected $repository;
    protected $controller;

    public function setUp()
    {
        parent::setUp();
        $this->request = new UserRequest;
        $this->repository = $this->getMockBuilder(UserRepository::class)->getMock();
        $this->controller = new UserController($this->request, $this->repository);
    }

    public function testIndex()
    {
        $this->repository->expects($this->once())
            ->method('getUsers');

        $this->controller->index();
    }

    public function testIndexWithSchool()
    {
        $this->repository->expects($this->once())
            ->method('getUsersBySchool');

        Input::merge(['school' => 1]);

        $this->controller->index();
    }

    public function testShow()
    {
        $this->repository->expects($this->once())
            ->method('getUserById')->with(parent::ID);

        $this->controller->show(parent::ID);
    }

    public function testCreate()
    {
        $this->repository->expects($this->once())
            ->method('createUser')
            ->with($this->request->name, $this->request->email, $this->request->password);

        $this->controller->create();
    }
    
    public function testUpdate()
    {
        $this->repository->expects($this->once())
            ->method('updateUser')
            ->with(parent::ID, $this->request->all())->willReturn(true);

        $this->assertEquals(
            $this->controller->respondSuccess('User successfully updated'),
            $this->controller->update(parent::ID)
        );
    }

    public function testUpdateWithEmptyAttributes()
    {
        $this->repository->expects($this->once())
            ->method('updateUser')
            ->with(parent::ID, $this->request->all())->willReturn(false);

        $this->assertEquals(
            $this->controller->respondUnprocessable('User attributes were not provided'),
            $this->controller->update(parent::ID)
        );
    }

    public function testDestroy()
    {
        $this->repository->expects($this->once())
            ->method('deleteUser')->with(parent::ID);

        $this->controller->destroy(parent::ID);
    }
}
