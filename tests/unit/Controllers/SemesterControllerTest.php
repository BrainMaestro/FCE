<?php

use Fce\Http\Controllers\SemesterController;
use Fce\Http\Requests\SemesterRequest;
use Fce\Repositories\Contracts\SemesterRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Response;

class SemesterControllerTest extends TestCase
{
    protected $request;
    protected $repository;
    protected $controller;

    public function setUp()
    {
        parent::setUp();
        $this->request = new SemesterRequest;
        $this->repository = $this->getMockBuilder(SemesterRepository::class)->getMock();
        $this->controller = new SemesterController($this->request, $this->repository);
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
        $this->request->merge(['current_semester' => true]);

        $this->repository->expects($this->once())
            ->method('createSemester')
            ->with($this->request->season, $this->request->year, $this->request->current_semester);

        $response = $this->controller->create();
        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
    }

    public function testCreateException()
    {
        $this->repository->expects($this->once())
            ->method('createSemester')
            ->with($this->request->season, $this->request->year, $this->request->current_semester)
            ->will($this->throwException(new Exception));

        $this->assertEquals(
            $this->controller->respondInternalServerError('Could not create semester'),
            $this->controller->create()
        );
    }

    public function testUpdate()
    {
        $this->repository->expects($this->once())
            ->method('setCurrentSemester')
            ->with(parent::ID)->willReturn(true);

        $this->assertEquals(
            $this->controller->respondSuccess('Semester successfully updated'),
            $this->controller->update(parent::ID)
        );
    }

    public function testUpdateCurrentSemesterTrue()
    {
        $this->request->merge(['current_semester' => true]);

        $this->repository->expects($this->once())
            ->method('getCurrentSemester');

        $this->assertEquals(
            $this->controller->respondSuccess('Semester successfully updated'),
            $this->controller->update(parent::ID)
        );
    }

    /**
     * Really long name...
     * @depends testUpdateCurrentSemesterTrue
     */
    public function testUpdateCurrentSemesterTrueWhereSemesterIsCurrentSemester()
    {
        $this->request->merge(['current_semester' => true]);

        $this->repository->expects($this->once())
            ->method('getCurrentSemester')
            ->willReturn(['data' => ['id' => parent::ID]]);

        $this->assertEquals(
            $this->controller->respondSuccess('Semester successfully updated'),
            $this->controller->update(parent::ID)
        );
    }

    public function testUpdateException()
    {
        // 404 - Not found
        $this->repository->method('setCurrentSemester')
            ->will($this->throwException(new ModelNotFoundException));

        $this->assertEquals(
            $this->controller->respondNotFound('Semester does not exist'),
            $this->controller->update(parent::ID)
        );

        // 500 - Internal server error
        $this->repository->method('setCurrentSemester')
            ->will($this->throwException(new Exception));

        $this->request->current_semester = true;
        $this->assertEquals(
            $this->controller->respondInternalServerError('Could not update semester'),
            $this->controller->update(parent::ID)
        );
    }

    public function testAddQuestionSet()
    {
        $this->repository->expects($this->once())
            ->method('addQuestionSet')
            ->with(parent::ID, $this->request->question_set_id, $this->request->evaluation_type);

        $this->assertEquals(
            $this->controller->respondSuccess('Question set successfully added to semester'),
            $this->controller->addQuestionSet(parent::ID)
        );
    }

    public function testAddQuestionSetException()
    {
        // 404 - Not Found
        $this->repository->method('addQuestionSet')
            ->will($this->throwException(new ModelNotFoundException));

        $this->assertEquals(
            $this->controller->respondNotFound('Semester does not exist'),
            $this->controller->addQuestionSet(parent::ID)
        );

        // 422 - Unprocessable
        $this->repository->method('addQuestionSet')
            ->will($this->throwException(new QueryException('', [], new \Exception)));

        $this->assertEquals(
            $this->controller->respondUnprocessable('Question set does not exist'),
            $this->controller->addQuestionSet(parent::ID)
        );

        // 500 - Internal server error
        $this->repository->method('addQuestionSet')
            ->will($this->throwException(new \Exception));

        $this->assertEquals(
            $this->controller->respondInternalServerError('Could not add question set to semester'),
            $this->controller->addQuestionSet(parent::ID)
        );
    }

    public function testUpdateQuestionSetStatus()
    {
        $this->repository->expects($this->once())
            ->method('setQuestionSetStatus')
            ->with(parent::ID, parent::ID, $this->request->status);

        $this->assertEquals(
            $this->controller->respondSuccess('Question set status successfully updated'),
            $this->controller->updateQuestionSetStatus(parent::ID, parent::ID)
        );
    }

    public function testUpdateQuestionSetStatusException()
    {
        // 404 - Not Found
        $this->repository->method('setQuestionSetStatus')
            ->will($this->throwException(new ModelNotFoundException));

        $this->assertEquals(
            $this->controller->respondNotFound('Semester does not exist'),
            $this->controller->updateQuestionSetStatus(parent::ID, parent::ID)
        );

        // 422 - Unprocessable
        $this->repository->method('setQuestionSetStatus')
            ->will($this->throwException(new QueryException('', [], new \Exception)));

        $this->assertEquals(
            $this->controller->respondUnprocessable('Question set does not exist'),
            $this->controller->updateQuestionSetStatus(parent::ID, parent::ID)
        );

        // 500 - Internal server error
        $this->repository->method('setQuestionSetStatus')
            ->will($this->throwException(new \Exception));

        $this->assertEquals(
            $this->controller->respondInternalServerError('Could not update question set status'),
            $this->controller->updateQuestionSetStatus(parent::ID, parent::ID)
        );
    }
}
