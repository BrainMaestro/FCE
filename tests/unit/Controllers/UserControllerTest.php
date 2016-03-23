<?php

use Fce\Http\Controllers\UserController;
use Fce\Http\Requests\UserCreateRequest;
use Fce\Http\Requests\UserUpdateRequest;
use Fce\Repositories\Contracts\UserRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Created by BrainMaestro
 * Date: 6/3/2016
 * Time: 12:35 AM
 */
class UserControllerTest extends TestCase
{
    protected $repository;
    protected $controller;

    public function setUp()
    {
        parent::setUp();
        $this->repository = $this->getMockBuilder(UserRepository::class)->getMock();
        $this->controller = new UserController($this->repository);
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

    public function testIndexException()
    {
        $this->repository->expects($this->once())
            ->method('getUsers')
            ->will($this->throwException(new Exception));

        $this->assertEquals(
            $this->controller->respondInternalServerError('Could not list users'),
            $this->controller->index()
        );
    }

    public function testIndexNotFoundException()
    {
        $this->repository->expects($this->once())
            ->method('getUsers')
            ->will($this->throwException(new ModelNotFoundException));

        $this->assertEquals(
            $this->controller->respondNotFound('Could not find any users'),
            $this->controller->index()
        );
    }

    public function testShow()
    {
        $this->repository->expects($this->once())
            ->method('getUserById')->with(parent::ID);

        $this->controller->show(parent::ID);
    }

    public function testShowNotFoundException()
    {
        $this->repository->expects($this->once())
            ->method('getUserById')->with(parent::ID)
            ->will($this->throwException(new ModelNotFoundException));

        $this->assertEquals(
            $this->controller->respondNotFound('Could not find user'),
            $this->controller->show(parent::ID)
        );
    }

    public function testShowException()
    {
        $this->repository->expects($this->once())
            ->method('getUserById')->with(parent::ID)
            ->will($this->throwException(new Exception));

        $this->assertEquals(
            $this->controller->respondInternalServerError('Could not show user'),
            $this->controller->show(parent::ID)
        );
    }

    public function testCreate()
    {
        $request = new UserCreateRequest;

        $this->repository->expects($this->once())
            ->method('createUser')
            ->with($request->name, $request->email, $request->password);

        $this->controller->create($request);
    }

    public function testCreateException()
    {
        $request = new UserCreateRequest;

        $this->repository->expects($this->once())
            ->method('createUser')
            ->with($request->name, $request->email, $request->password)
            ->will($this->throwException(new Exception));

        $this->assertEquals(
            $this->controller->respondInternalServerError('Could not create user'),
            $this->controller->create($request)
        );
    }

    public function testUpdate()
    {
        $request = new UserUpdateRequest;

        $this->repository->expects($this->once())
            ->method('updateUser')
            ->with(parent::ID, $request->all())->willReturn(true);

        $this->assertEquals(
            $this->controller->respondSuccess('User successfully updated'),
            $this->controller->update($request, parent::ID)
        );
    }

    public function testUpdateWithEmptyAttributes()
    {
        $request = new UserUpdateRequest;

        $this->repository->expects($this->once())
            ->method('updateUser')
            ->with(parent::ID, $request->all())->willReturn(false);

        $this->assertEquals(
            $this->controller->respondUnprocessable('User attributes were not provided'),
            $this->controller->update($request, parent::ID)
        );
    }

    public function testUpdateNotFoundException()
    {
        $request = new UserUpdateRequest;

        $this->repository->expects($this->once())
            ->method('updateUser')
            ->will($this->throwException(new ModelNotFoundException));

        $this->assertEquals(
            $this->controller->respondNotFound('Could not find user'),
            $this->controller->update($request, parent::ID)
        );
    }

    public function testUpdateException()
    {
        $request = new UserUpdateRequest;

        $this->repository->expects($this->once())
            ->method('updateUser')
            ->will($this->throwException(new Exception));

        $this->assertEquals(
            $this->controller->respondInternalServerError('Could not update user'),
            $this->controller->update($request, parent::ID)
        );
    }

    public function testDestroy()
    {
        $this->repository->expects($this->once())
            ->method('deleteUser')->with(parent::ID);

        $this->controller->destroy(parent::ID);
    }

    public function testDestroyException()
    {
        $this->repository->expects($this->once())
            ->method('deleteUser')
            ->will($this->throwException(new Exception));

        $this->assertEquals(
            $this->controller->respondInternalServerError('Could not delete user'),
            $this->controller->destroy(parent::ID)
        );
    }
}
