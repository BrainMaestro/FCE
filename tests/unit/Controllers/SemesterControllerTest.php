<?php

use Fce\Http\Controllers\SemesterController;
use Fce\Http\Requests\SemesterCreateRequest;
use Fce\Http\Requests\SemesterQuestionSetRequest;
use Fce\Http\Requests\SemesterStatusRequest;
use Fce\Http\Requests\SemesterUpdateRequest;
use Fce\Repositories\Contracts\SemesterRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Response;

class SemesterControllerTest extends TestCase
{
    protected $repository;
    protected $controller;

    public function setUp()
    {
        parent::setUp();
        $this->repository = $this->getMockBuilder(SemesterRepository::class)->getMock();
        $this->controller = new SemesterController($this->repository);
    }

    public function testIndex()
    {
        $this->repository->expects($this->once())
            ->method('getSemesters');

        $this->controller->index();
    }

    public function testIndexException()
    {
        $this->repository->expects($this->once())
            ->method('getSemesters')
            ->will($this->throwException(new Exception));

        $this->assertEquals(
            $this->controller->respondInternalServerError('Could not list semesters'),
            $this->controller->index()
        );
    }

    public function testIndexNotFoundException()
    {
        $this->repository->expects($this->once())
            ->method('getSemesters')
            ->will($this->throwException(new \Illuminate\Database\Eloquent\ModelNotFoundException()));

        $this->assertEquals(
            $this->controller->respondNotFound('Could not find any semesters'),
            $this->controller->index()
        );
    }

    public function testCreate()
    {
        $request = new SemesterCreateRequest;
        $request->merge(['current_semester' => true]);

        $this->repository->expects($this->once())
            ->method('createSemester')
            ->with($request->season, $request->year, $request->current_semester);

        $response = $this->controller->create($request);
        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
    }

    public function testCreateException()
    {
        $request = new SemesterCreateRequest;

        $this->repository->expects($this->once())
            ->method('createSemester')
            ->with($request->season, $request->year, $request->current_semester)
            ->will($this->throwException(new Exception));

        $this->assertEquals(
            $this->controller->respondInternalServerError('Could not create semester'),
            $this->controller->create($request)
        );
    }

    public function testUpdate()
    {
        $request = new SemesterUpdateRequest;

        $this->repository->expects($this->once())
            ->method('setCurrentSemester')
            ->with(parent::ID)->willReturn(true);

        $this->assertEquals(
            $this->controller->respondSuccess('Semester successfully updated'),
            $this->controller->update($request, parent::ID)
        );
    }

    public function testUpdateCurrentSemesterTrue()
    {
        $request = new SemesterUpdateRequest;
        $request->merge(['current_semester' => true]);

        $this->repository->expects($this->once())
            ->method('getCurrentSemester');

        $this->assertEquals(
            $this->controller->respondSuccess('Semester successfully updated'),
            $this->controller->update($request, parent::ID)
        );

        return $request;
    }

    /**
     * Really long name...
     * @depends testUpdateCurrentSemesterTrue
     */
    public function testUpdateCurrentSemesterTrueWhereSemesterIsCurrentSemester($request)
    {
        $this->repository->expects($this->once())
            ->method('getCurrentSemester')
            ->willReturn(['data' => ['id' => parent::ID]]);

        $this->assertEquals(
            $this->controller->respondSuccess('Semester successfully updated'),
            $this->controller->update($request, parent::ID)
        );
    }

    public function testUpdateException()
    {
        $request = new SemesterUpdateRequest;

        // 404 - Not found
        $this->repository->method('setCurrentSemester')
            ->will($this->throwException(new ModelNotFoundException));

        $this->assertEquals(
            $this->controller->respondNotFound('Semester does not exist'),
            $this->controller->update($request, parent::ID)
        );

        // 500 - Internal server error
        $this->repository->method('setCurrentSemester')
            ->will($this->throwException(new Exception));

        $request->current_semester = true;
        $this->assertEquals(
            $this->controller->respondInternalServerError('Could not update semester'),
            $this->controller->update($request, parent::ID)
        );
    }

    public function testAddQuestionSet()
    {
        $request = new SemesterQuestionSetRequest;

        $this->repository->expects($this->once())
            ->method('addQuestionSet')
            ->with(parent::ID, $request->question_set_id, $request->evaluation_type);

        $this->assertEquals(
            $this->controller->respondSuccess('Question set successfully added to semester'),
            $this->controller->addQuestionSet($request, parent::ID)
        );
    }

    public function testAddQuestionSetException()
    {
        $request = new SemesterQuestionSetRequest;

        // 404 - Not Found
        $this->repository->method('addQuestionSet')
            ->will($this->throwException(new ModelNotFoundException));

        $this->assertEquals(
            $this->controller->respondNotFound('Semester does not exist'),
            $this->controller->addQuestionSet($request, parent::ID)
        );

        // 422 - Unprocessable
        $this->repository->method('addQuestionSet')
            ->will($this->throwException(new QueryException('', [], new \Exception)));

        $this->assertEquals(
            $this->controller->respondUnprocessable('Question set does not exist'),
            $this->controller->addQuestionSet($request, parent::ID)
        );

        // 500 - Internal server error
        $this->repository->method('addQuestionSet')
            ->will($this->throwException(new \Exception));

        $this->assertEquals(
            $this->controller->respondInternalServerError('Could not add question set to semester'),
            $this->controller->addQuestionSet($request, parent::ID)
        );
    }

    public function testUpdateQuestionSetStatus()
    {
        $request = new SemesterStatusRequest;

        $this->repository->expects($this->once())
            ->method('setQuestionSetStatus')
            ->with(parent::ID, parent::ID, $request->status);

        $this->assertEquals(
            $this->controller->respondSuccess('Question set status successfully updated'),
            $this->controller->updateQuestionSetStatus($request, parent::ID, parent::ID)
        );
    }

    public function testUpdateQuestionSetStatusException()
    {
        $request = new SemesterStatusRequest;

        // 404 - Not Found
        $this->repository->method('setQuestionSetStatus')
            ->will($this->throwException(new ModelNotFoundException));

        $this->assertEquals(
            $this->controller->respondNotFound('Semester does not exist'),
            $this->controller->updateQuestionSetStatus($request, parent::ID, parent::ID)
        );

        // 422 - Unprocessable
        $this->repository->method('setQuestionSetStatus')
            ->will($this->throwException(new QueryException('', [], new \Exception)));

        $this->assertEquals(
            $this->controller->respondUnprocessable('Question set does not exist'),
            $this->controller->updateQuestionSetStatus($request, parent::ID, parent::ID)
        );

        // 500 - Internal server error
        $this->repository->method('setQuestionSetStatus')
            ->will($this->throwException(new \Exception));

        $this->assertEquals(
            $this->controller->respondInternalServerError('Could not update question set status'),
            $this->controller->updateQuestionSetStatus($request, parent::ID, parent::ID)
        );
    }
}
