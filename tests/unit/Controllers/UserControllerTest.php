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
        $id = 1;
        $this->repository->expects($this->once())
            ->method('getUserById')->with($id);

        $this->controller->show($id);
    }

    public function testShowNotFoundException()
    {
        $id = 1;
        $this->repository->expects($this->once())
            ->method('getUserById')->with($id)
            ->will($this->throwException(new ModelNotFoundException));

        $this->assertEquals(
            $this->controller->respondInternalServerError('Could not find user'),
            $this->controller->show($id)
        );
    }

    public function testShowException()
    {
        $id = 1;
        $this->repository->expects($this->once())
            ->method('getUserById')->with($id)
            ->will($this->throwException(new Exception));

        $this->assertEquals(
            $this->controller->respondInternalServerError('Could not find user'),
            $this->controller->show($id)
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
        $id = 1;
        $request = new UserUpdateRequest;

        $this->repository->expects($this->once())
            ->method('updateUser')
            ->with($id, $request->all())->willReturn(true);

        $response = $this->controller->update($request, $id);
        $this->assertEquals(null, $response);
    }

    public function testUpdateWithEmptyAttributes()
    {
        $id = 1;
        $request = new UserUpdateRequest;

        $this->repository->expects($this->once())
            ->method('updateUser')
            ->with($id, $request->all())->willReturn(false);

        $this->assertEquals(
            $this->controller->respondUnprocessable('User attributes were not provided'),
            $this->controller->update($request, $id)
        );
    }

    public function testUpdateException()
    {
        $id = 1;
        $request = new UserUpdateRequest;

        $this->repository->expects($this->once())
            ->method('updateUser')
            ->will($this->throwException(new Exception));

        $this->assertEquals(
            $this->controller->respondInternalServerError('Could not update user'),
            $this->controller->update($request, $id)
        );
    }

    public function testDestroy()
    {
        $id = 1;

        $this->repository->expects($this->once())
            ->method('deleteUser')->with($id);

        $this->controller->destroy($id);
    }

    public function testDestroyException()
    {
        $id = 1;

        $this->repository->expects($this->once())
            ->method('deleteUser')
            ->will($this->throwException(new Exception));

        $this->assertEquals(
            $this->controller->respondInternalServerError('Could not delete user'),
            $this->controller->destroy($id)
        );
    }
}
