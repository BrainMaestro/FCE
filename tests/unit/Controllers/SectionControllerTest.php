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
            'school' => parent::ID
        ]);

        $this->controller->index();
    }

    public function testIndexNoCriteria()
    {
        $this->repository->expects($this->once())
            ->method('getSectionsBySemester');

        $this->controller->index();
    }

    public function testIndexNotFoundException()
    {
        $semesterId = parent::ID;
        $this->repository->expects($this->once())
            ->method('getSectionsBySemester')
            ->with($semesterId)
            ->will($this->throwException(new ModelNotFoundException));

        Input::merge(['semester' => parent::ID]);

        $this->assertEquals(
            $this->controller->respondNotFound('Could not find section(s)'),
            $this->controller->index()
        );
    }

    public function testIndexException()
    {
        $this->repository->expects($this->once())
            ->method('getSectionsBySemester')
            ->will($this->throwException(new Exception));

        $this->assertEquals(
            $this->controller->respondInternalServerError('Could not list section(s)'),
            $this->controller->index()
        );
    }


    public function testShow()
    {
        $id = parent::ID;
        $this->repository->expects($this->once())
            ->method('getSectionById')->with($id);

        $this->controller->show($id);
    }

    public function testShowNotFoundException()
    {
        $this->repository->expects($this->once())
            ->method('getSectionById')
            ->with(parent::ID)
            ->will($this->throwException(new ModelNotFoundException));

        $this->assertEquals(
            $this->controller->respondNotFound('Could not find section'),
            $this->controller->show(parent::ID)
        );
    }

    public function testShowException()
    {
        $id = parent::ID;
        $this->repository->expects($this->once())
            ->method('getSectionById')->with($id)
            ->will($this->throwException(new Exception));

        $this->assertEquals(
            $this->controller->respondInternalServerError('Could not show section'),
            $this->controller->show($id)
        );
    }

    public function testCreate()
    {
        $this->repository->expects($this->once())
            ->method('createSection')
            ->with($this->request->all());

        $this->controller->create();
    }

    public function testCreateException()
    {
        $this->repository->expects($this->once())
            ->method('createSection')
            ->with($this->request->all())
            ->will($this->throwException(new Exception));

        $this->assertEquals(
            $this->controller->respondInternalServerError('Could not create section'),
            $this->controller->create()
        );
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

    public function testUpdateNotFoundException()
    {
        $id = parent::ID;

        $this->repository->expects($this->once())
            ->method('updateSection')
            ->will($this->throwException(new ModelNotFoundException));

        $this->assertEquals(
            $this->controller->respondNotFound('Could not find section'),
            $this->controller->update($id)
        );
    }

    public function testUpdateException()
    {
        $id = parent::ID;

        $this->repository->expects($this->once())
            ->method('updateSection')
            ->will($this->throwException(new Exception));

        $this->assertEquals(
            $this->controller->respondInternalServerError('Could not update section'),
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

    public function testUpdateStatusNotFoundException()
    {
        $id = parent::ID;

        $this->repository->expects($this->once())
            ->method('getSectionById')
            ->will($this->throwException(new ModelNotFoundException));

        $this->assertEquals(
            $this->controller->respondNotFound('Could not find section'),
            $this->controller->updateStatus($id)
        );
    }

    public function testUpdateStatusException()
    {
        $id = parent::ID;

        $this->repository->expects($this->once())
            ->method('getSectionById')
            ->will($this->throwException(new Exception));

        $this->assertEquals(
            $this->controller->respondInternalServerError('Could not update section status'),
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

    public function testShowKeysNotFound()
    {
        $id = parent::ID;
        $this->keyRepository->expects($this->once())
            ->method('getKeysBySection')->with($id)
            ->will($this->throwException(new ModelNotFoundException));

        $this->assertEquals(
            $this->controller->respondNotFound('Could not find key(s)'),
            $this->controller->showKeys($this->keyRepository, $id)
        );
    }

    public function testShowKeysException()
    {
        $id = parent::ID;

        $this->keyRepository->expects($this->once())
            ->method('getKeysBySection')
            ->will($this->throwException(new Exception));

        $this->assertEquals(
            $this->controller->respondInternalServerError('Could not show key(s)'),
            $this->controller->showKeys($this->keyRepository, $id)
        );
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

    public function testListReportsNotFoundException()
    {
        $id = parent::ID;
        $this->repository->expects($this->once())
            ->method('getSectionById')
            ->with($id)
            ->will($this->throwException(new ModelNotFoundException));

        $this->assertEquals(
            $this->controller->respondNotFound('Could not find section'),
            $this->controller->listReports($id)
        );
    }

    public function testListReportsException()
    {
        $id = parent::ID;
        $this->repository->expects($this->once())
            ->method('getSectionById')
            ->with($id)
            ->will($this->throwException(new \Exception));

        $this->assertEquals(
            $this->controller->respondInternalServerError('Could not list reports'),
            $this->controller->listReports($id)
        );
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

    public function testShowReportNotFound()
    {
        $id = parent::ID;
        $questionSetId = parent::ID;
        $this->evaluationRepository->expects($this->once())
            ->method('getEvaluationsBySectionAndQuestionSet')->with($id, $questionSetId)
            ->will($this->throwException(new ModelNotFoundException));

        $this->assertEquals(
            $this->controller->respondNotFound('Could not find report'),
            $this->controller->showReport($this->evaluationRepository, $this->commentRepository, $id, $questionSetId)
        );
    }

    public function testShowReportException()
    {
        $id = parent::ID;
        $questionSetId = parent::ID;
        $this->evaluationRepository->expects($this->once())
            ->method('getEvaluationsBySectionAndQuestionSet')->with($id, $questionSetId)
            ->will($this->throwException(new Exception));

        $this->assertEquals(
            $this->controller->respondInternalServerError('Could not show report'),
            $this->controller->showReport($this->evaluationRepository, $this->commentRepository, $id, $questionSetId)
        );
    }
}
