<?php

/* [Created by SkaeX @ 2016-03-19 20:18:11]  */

use Fce\Http\Controllers\SectionController;
use Fce\Http\Requests\SectionRequest;
use Fce\Repositories\Contracts\CommentRepository;
use Fce\Repositories\Contracts\EvaluationRepository;
use Fce\Repositories\Contracts\KeyRepository;
use Fce\Repositories\Contracts\SectionRepository;
use Fce\Repositories\Contracts\SemesterRepository;
use Fce\Utility\Status;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SectionControllerTest extends TestCase
{
    protected $request;
    protected $repository;
    protected $keyRepository;
    protected $semesterRepository;
    protected $controller;
    protected $evaluationRepository;
    protected $commentRepository;

    public function setUp()
    {
        parent::setUp();
        $this->request = new SectionRequest;
        $this->repository = $this->getMockBuilder(SectionRepository::class)->getMock();
        $this->keyRepository = $this->getMockBuilder(KeyRepository::class)->getMock();
        $this->evaluationRepository = $this->getMockBuilder(EvaluationRepository::class)->getMock();
        $this->semesterRepository = $this->getMockBuilder(SemesterRepository::class)->getMock();
        $this->commentRepository = $this->getMockBuilder(CommentRepository::class)->getMock();

        $this->controller = new SectionController(
            $this->request,
            $this->repository,
            $this->semesterRepository
        );
    }

    public function testIndexWithSemester()
    {
        $this->repository->expects($this->once())
            ->method('getSectionsBySemester');

        Input::merge(['semester' => parent::ID]);

        $this->controller->index();
    }

    public function testIndexWithSemesterAndSchool()
    {
        $this->repository->expects($this->once())
            ->method('getSectionsBySemesterAndSchool');

        Input::merge([
            'semester' => parent::ID,
            'school' => parent::ID,
        ]);

        $this->controller->index();
    }

    public function testIndexNoCriteria()
    {
        $this->repository->expects($this->once())
            ->method('getSectionsBySemester');

        $this->controller->index();
    }
    
    public function testShow()
    {
        $id = parent::ID;
        $this->repository->expects($this->once())
            ->method('getSectionById')->with($id);

        $this->controller->show($id);
    }

    public function testCreate()
    {
        $this->repository->expects($this->once())
            ->method('createSection')
            ->with($this->request->all());

        $this->controller->create();
    }

    public function testUpdate()
    {
        $id = parent::ID;

        $this->repository->expects($this->once())
            ->method('updateSection')
            ->with($id, $this->request->all())->willReturn(true);

        $this->assertEquals(
            $this->controller->respondSuccess('Section was updated successfully'),
            $this->controller->update($id)
        );
    }

    public function testUpdateWithEmptyAttributes()
    {
        $id = parent::ID;

        $this->repository->expects($this->once())
            ->method('updateSection')
            ->with($id, $this->request->all())->willReturn(false);

        $this->assertEquals(
            $this->controller->respondUnprocessable('Section attribute(s) were not provided'),
            $this->controller->update($id)
        );
    }

    public function testUpdateStatus()
    {
        $id = parent::ID;

        $this->repository->expects($this->exactly(2))
            ->method('getSectionById')
            ->with($id);

        $this->repository->expects($this->exactly(2))
            ->method('updateSection')
            ->with($id);

        Event::shouldReceive('fire')->once()
            ->with(Fce\Events\Event::SECTION_OPENED, $id, false);

        Event::shouldReceive('fire')->once()
            ->with(Fce\Events\Event::SECTION_CLOSED, $id, false);

        $this->request->merge(['status' => Status::OPEN]);

        $this->assertEquals(
            $this->controller->respondSuccess('Section status updated successfully'),
            $this->controller->updateStatus($id)
        );

        $this->request->merge(['status' => Status::DONE]);

        $this->assertEquals(
            $this->controller->respondSuccess('Section status updated successfully'),
            $this->controller->updateStatus($id)
        );
    }

    public function testUpdateStatusWithAlreadyExistingStatus()
    {
        $id = parent::ID;
        $status = Status::OPEN;

        $this->repository->expects($this->once())
            ->method('getSectionById')
            ->with($id)
            ->willReturn(['data' => ['status' => $status]]);

        $this->request->merge(['status' => $status]);

        $this->assertEquals(
            $this->controller->respondUnprocessable('Section is already ' . $status),
            $this->controller->updateStatus($id)
        );
    }

    public function testShowKeys()
    {
        $id = parent::ID;
        $this->keyRepository->expects($this->once())
            ->method('getKeysBySection')->with($id);

        $this->controller->showKeys($this->keyRepository, $id);
    }

    public function testListReports()
    {
        $id = parent::ID;
        $this->repository->expects($this->once())
            ->method('getSectionById')
            ->with($id)
            ->willReturn(['data' => ['semester_id' => $id]]);

        $this->semesterRepository->expects($this->once())
            ->method('getSemesterById')->with($id);

        $this->controller->listReports($id);
    }

    public function testShowReport()
    {
        $id = parent::ID;
        $questionSetId = parent::ID;
        $this->evaluationRepository->expects($this->once())
            ->method('getEvaluationsBySectionAndQuestionSet')->with($id, $questionSetId);
        $this->commentRepository->expects($this->once())
            ->method('getComments')->with($id, $questionSetId);

        $this->controller->showReport($this->evaluationRepository, $this->commentRepository, $id, $questionSetId);
    }
}
