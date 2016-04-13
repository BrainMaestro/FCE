<?php

use Fce\Http\Controllers\SemesterController;
use Fce\Http\Requests\SemesterRequest;
use Fce\Repositories\Contracts\SemesterRepository;
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

    public function testCreate()
    {
        $this->request->merge(['current_semester' => true]);

        $this->repository->expects($this->once())
            ->method('createSemester')
            ->with($this->request->season, $this->request->year, $this->request->current_semester);

        $response = $this->controller->create();
        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
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

    public function testUpdateQuestionSetStatus()
    {
        $this->repository->expects($this->exactly(3))
            ->method('getCurrentSemester')->willReturn([
            'data' => [
                'id' => parent::ID,
                'questionSets' => [
                    'data' => [
                        [
                            'id' => parent::ID,
                            'status' => Fce\Utility\Status::LOCKED,
                        ],
                    ],
                ],
            ],
        ]);

        $this->repository->expects($this->exactly(2))
            ->method('setQuestionSetStatus')
            ->withConsecutive(
                [parent::ID, parent::ID, Fce\Utility\Status::OPEN],
                [parent::ID, parent::ID, Fce\Utility\Status::DONE]
            );

        Event::shouldReceive('fire')->once()
            ->with(Fce\Events\Event::QUESTION_SET_OPENED, parent::ID, false);

        Event::shouldReceive('fire')->once()
            ->with(Fce\Events\Event::QUESTION_SET_CLOSED, [], false);

        $this->request->merge(['status' => Fce\Utility\Status::LOCKED]);

        $this->assertEquals(
            $this->controller->respondUnprocessable('Question set is already ' . Fce\Utility\Status::LOCKED),
            $this->controller->updateQuestionSetStatus(parent::ID)
        );

        $this->request->merge(['status' => Fce\Utility\Status::OPEN]);

        $this->assertEquals(
            $this->controller->respondSuccess('Question set status successfully updated'),
            $this->controller->updateQuestionSetStatus(parent::ID)
        );

        $this->request->merge(['status' => Fce\Utility\Status::DONE]);

        $this->assertEquals(
            $this->controller->respondSuccess('Question set status successfully updated'),
            $this->controller->updateQuestionSetStatus(parent::ID)
        );
    }
}
