<?php

use Fce\Http\Controllers\SchoolController;
use Fce\Http\Requests\SchoolRequest;
use Fce\Repositories\Contracts\SchoolRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SchoolControllerTest extends TestCase
{
    protected $repository;
    protected $controller;

    public function setUp()
    {
        parent::setUp();
        $this->repository = $this->getMockBuilder(SchoolRepository::class)->getMock();
        $this->controller = new SchoolController($this->repository);
    }

    public function testIndex()
    {
        $this->repository->expects($this->once())
            ->method('getSchools');

        $this->controller->index();
    }

    public function testIndexException()
    {
        $this->repository->expects($this->once())
            ->method('getSchools')
            ->will($this->throwException(new Exception));

        $this->assertEquals(
            $this->controller->respondInternalServerError('Could not list schools'),
            $this->controller->index()
        );
    }

    public function testIndexNotFoundException()
    {
        $this->repository->expects($this->once())
            ->method('getSchools')
            ->will($this->throwException(new ModelNotFoundException));

        $this->assertEquals(
            $this->controller->respondNotFound('Could not find any schools'),
            $this->controller->index()
        );
    }

    public function testShow()
    {
        $this->repository->expects($this->once())
            ->method('getSchoolById')->with(parent::ID);

        $this->controller->show(parent::ID);
    }

    public function testShowNotFoundException()
    {
        $this->repository->expects($this->once())
            ->method('getSchoolById')->with(parent::ID)
            ->will($this->throwException(new ModelNotFoundException));

        $this->assertEquals(
            $this->controller->respondNotFound('Could not find school'),
            $this->controller->show(parent::ID)
        );
    }

    public function testShowException()
    {
        $this->repository->expects($this->once())
            ->method('getSchoolById')->with(parent::ID)
            ->will($this->throwException(new Exception));

        $this->assertEquals(
            $this->controller->respondInternalServerError('Could not show school'),
            $this->controller->show(parent::ID)
        );
    }

    public function testCreate()
    {
        $request = new SchoolRequest;

        $this->repository->expects($this->once())
            ->method('createSchool')
            ->with($request->school, $request->description);

        $this->controller->create($request);
    }

    public function testCreateException()
    {
        $request = new SchoolRequest;

        $this->repository->expects($this->once())
            ->method('createSchool')
            ->with($request->school, $request->description)
            ->will($this->throwException(new Exception));

        $this->assertEquals(
            $this->controller->respondInternalServerError('Could not create school'),
            $this->controller->create($request)
        );
    }
    public function testUpdate()
    {
        $request = new SchoolRequest;

        $this->repository->expects($this->once())
            ->method('updateSchool')
            ->with(parent::ID, $request->all())->willReturn(true);

        $response = $this->controller->update($request, parent::ID);
        $this->assertEquals(null, $response);
    }

    public function testUpdateWithEmptyAttributes()
    {
        $request = new SchoolRequest;

        $this->repository->expects($this->once())
            ->method('updateSchool')
            ->with(parent::ID, $request->all())->willReturn(false);

        $this->assertEquals(
            $this->controller->respondUnprocessable('School attributes were not provided'),
            $this->controller->update($request, parent::ID)
        );
    }

    public function testUpdateException()
    {
        $request = new SchoolRequest;

        $this->repository->expects($this->once())
            ->method('updateSchool')
            ->will($this->throwException(new Exception));

        $this->assertEquals(
            $this->controller->respondInternalServerError('Could not update school'),
            $this->controller->update($request, parent::ID)
        );
    }
}
