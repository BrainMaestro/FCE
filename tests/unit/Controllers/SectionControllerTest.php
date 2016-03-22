<?php

/* [Created by SkaeX @ 2016-03-19 20:18:11]  */

use Fce\Http\Controllers\SectionController;
use Fce\Http\Requests\SectionRequest;
use Fce\Repositories\Contracts\SectionRepository;
use Fce\Repositories\Contracts\EvaluationRepository;
use Fce\Repositories\Contracts\KeyRepository;
use Fce\Repositories\Contracts\SemesterRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SectionControllerTest extends TestCase
{
    protected $repository;
    protected $keyRepository;
    protected $semesterRepository;
    protected $controller;
    protected $evaluationRepository;

    public function setUp()
    {
        parent::setUp();
        $this->repository = $this->getMockBuilder(SectionRepository::class)->getMock();
        $this->keyRepository = $this->getMockBuilder(KeyRepository::class)->getMock();
        $this->evaluationRepository = $this->getMockBuilder(EvaluationRepository::class)->getMock();
        $this->semesterRepository = $this->getMockBuilder(SemesterRepository::class)->getMock();

        $this->controller = new SectionController(
            $this->repository,
            $this->keyRepository,
            $this->evaluationRepository,
            $this->semesterRepository
        );
    }

    public function testIndexWithSemester()
    {
        $this->repository->expects($this->once())
            ->method('getSectionsBySemester');

        Input::merge(['semester' => Parent::ID]);

        $this->controller->index();
    }

    public function testIndexWithSemesterAndSchool()
    {
        $this->repository->expects($this->once())
            ->method('getSectionsBySemesterAndSchool');

        Input::merge([
            'semester' => Parent::ID,
            'school' => Parent::ID
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
        $semesterId = Parent::ID;
        $this->repository->expects($this->once())
            ->method('getSectionsBySemester')
            ->with($semesterId)
            ->will($this->throwException(new ModelNotFoundException));

        Input::merge(['semester' => Parent::ID]);

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
        $id = Parent::ID;
        $this->repository->expects($this->once())
            ->method('getSectionById')->with($id);

        $this->controller->show($id);
    }

    public function testShowNotFoundException()
    {
        $this->repository->expects($this->once())
            ->method('getSectionById')
            ->with(Parent::ID)
            ->will($this->throwException(new ModelNotFoundException));

        $this->assertEquals(
            $this->controller->respondNotFound('Could not find section'),
            $this->controller->show(Parent::ID)
        );
    }

    public function testShowException()
    {
        $id = Parent::ID;
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
        $request = new SectionRequest;

        $this->repository->expects($this->once())
            ->method('createSection')
            ->with($request->all());

        $this->controller->create($request);
    }

    public function testCreateException()
    {
        $request = new SectionRequest;

        $this->repository->expects($this->once())
            ->method('createSection')
            ->with($request->all())
            ->will($this->throwException(new Exception));

        $this->assertEquals(
            $this->controller->respondInternalServerError('Could not create section'),
            $this->controller->create($request)
        );
    }

    public function testUpdate()
    {
        $id = Parent::ID;
        $request = new SectionRequest;

        $this->repository->expects($this->once())
            ->method('updateSection')
            ->with($id, $request->all())->willReturn(true);

        $response = $this->controller->update($request, $id);
        $this->assertEquals(null, $response);
    }

    public function testUpdateWithEmptyAttributes()
    {
        $id = Parent::ID;
        $request = new SectionRequest;

        $this->repository->expects($this->once())
            ->method('updateSection')
            ->with($id, $request->all())->willReturn(false);

        $this->assertEquals(
            $this->controller->respondUnprocessable('Section attribute(s) were not provided'),
            $this->controller->update($request, $id)
        );
    }
    
    public function testUpdateNotFoundException()
    {
        $id = Parent::ID;
        $request = new SectionRequest;

        $this->repository->expects($this->once())
            ->method('updateSection')
            ->will($this->throwException(new ModelNotFoundException));

        $this->assertEquals(
            $this->controller->respondNotFound('Could not find section'),
            $this->controller->update($request, $id)
        );
    }
    
    public function testUpdateException()
    {
        $id = Parent::ID;
        $request = new SectionRequest;

        $this->repository->expects($this->once())
            ->method('updateSection')
            ->will($this->throwException(new Exception));

        $this->assertEquals(
            $this->controller->respondInternalServerError('Could not update section'),
            $this->controller->update($request, $id)
        );
    }

    public function testShowKeys()
    {
        $id = Parent::ID;
        $this->keyRepository->expects($this->once())
            ->method('getKeysBySection')->with($id);

        $this->controller->showKeys($id);
    }

    public function testShowKeysNotFound()
    {
        $id = Parent::ID;
        $this->keyRepository->expects($this->once())
            ->method('getKeysBySection')->with($id)
            ->will($this->throwException(new ModelNotFoundException));

        $this->assertEquals(
            $this->controller->respondNotFound('Could not find key(s)'),
            $this->controller->showkeys($id)
        );
    }

    public function testShowKeysException()
    {
        $id = Parent::ID;

        $this->keyRepository->expects($this->once())
            ->method('getKeysBySection')
            ->will($this->throwException(new Exception));

        $this->assertEquals(
            $this->controller->respondInternalServerError('Could not show key(s)'),
            $this->controller->showKeys($id)
        );
    }

    public function testListReports()
    {
        $id = Parent::ID;
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
        $id = Parent::ID;
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
        $id = Parent::ID;
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
        $id = Parent::ID;
        $questionSetId = Parent::ID;
        $this->evaluationRepository->expects($this->once())
            ->method('getEvaluationsBySectionAndQuestionSet')->with($id, $questionSetId);

        $this->controller->showReport($id, $questionSetId);
    }

    public function testShowReportNotFound()
    {
        $id = Parent::ID;
        $questionSetId = Parent::ID;
        $this->evaluationRepository->expects($this->once())
            ->method('getEvaluationsBySectionAndQuestionSet')->with($id, $questionSetId)
            ->will($this->throwException(new ModelNotFoundException));

        $this->assertEquals(
            $this->controller->respondNotFound('Could not find report'),
            $this->controller->showReport($id, $questionSetId)
        );
    }

    public function testShowReportException()
    {
        $id = Parent::ID;
        $questionSetId = Parent::ID;
        $this->evaluationRepository->expects($this->once())
            ->method('getEvaluationsBySectionAndQuestionSet')->with($id, $questionSetId)
            ->will($this->throwException(new Exception));

        $this->assertEquals(
            $this->controller->respondInternalServerError('Could not show report'),
            $this->controller->showReport($id, $questionSetId)
        );
    }
}
