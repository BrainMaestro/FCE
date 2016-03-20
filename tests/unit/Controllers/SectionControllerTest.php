<?php

/* [Created by SkaeX @ 2016-03-19 20:18:11]  */

use Fce\Http\Controllers\SectionController;
use Fce\Http\Requests\SectionRequest;
use Fce\Repositories\Contracts\SectionRepository;
use Fce\Repositories\Contracts\EvaluationRepository;
use Fce\Repositories\Contracts\KeyRepository;

class SectionControllerTest extends TestCase
{
    protected $repository;
    protected $keyRepository;
    protected $controller;
    protected $evaluationRepository;

    public function setUp()
    {
        parent::setUp();
        $this->repository = $this->getMockBuilder(SectionRepository::class)->getMock();
        $this->keyRepository = $this->getMockBuilder(KeyRepository::class)->getMock();
        $this->evaluationRepository = $this->getMockBuilder(EvaluationRepository::class)->getMock();

        $this->controller = new SectionController($this->repository, $this->keyRepository, $this->evaluationRepository);
    }

    public function testIndexWithSemester()
    {
        $this->repository->expects($this->once())
            ->method('getSectionsBySemester');

        Input::merge(['semester' => 1]);

        $this->controller->index();
    }

    public function testIndexWithSemesterAndSchool()
    {
        $this->repository->expects($this->once())
            ->method('getSectionsBySemesterAndSchool');

        Input::merge(['semester' => 1]);
        Input::merge(['school' => 1]);

        $this->controller->index();
    }

    public function testIndexNoCriteria()
    {
        $this->assertEquals(
            $this->controller->respondUnprocessable('Could not find any criteria'),
            $this->controller->index()
        );
    }

    
    public function testIndexNotFoundException()
    {
        $semesterId = 1;
        $this->repository->expects($this->once())
            ->method('getSectionsBySemester')
            ->with($semesterId)
            ->will($this->throwException(new \Illuminate\Database\Eloquent\ModelNotFoundException()));

        Input::merge(['semester' => 1]);

        $this->assertEquals(
            $this->controller->respondNotFound('Could not find such section(s)'),
            $this->controller->index()
        );
    }


    public function testShow()
    {
        $id = 1;
        $this->repository->expects($this->once())
            ->method('getSectionById')->with($id);

        $this->controller->show($id);
    }

    public function testShowException()
    {
        $id = 1;
        $this->repository->expects($this->once())
            ->method('getSectionById')->with($id)
            ->will($this->throwException(new Exception));

        $this->assertEquals(
            $this->controller->respondInternalServerError('Could not find section'),
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
        $id = 1;
        $request = new SectionRequest;

        $this->repository->expects($this->once())
            ->method('updateSection')
            ->with($id, $request->all())->willReturn(true);

        $response = $this->controller->update($request, $id);
        $this->assertEquals(null, $response);
    }

    public function testUpdateWithEmptyAttributes()
    {
        $id = 1;
        $request = new SectionRequest;

        $this->repository->expects($this->once())
            ->method('updateSection')
            ->with($id, $request->all())->willReturn(false);

        $this->assertEquals(
            $this->controller->respondUnprocessable('Section attribute(s) were not provided'),
            $this->controller->update($request, $id)
        );
    }

    public function testUpdateException()
    {
        $id = 1;
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
        $id = 1;
        $this->keyRepository->expects($this->once())
            ->method('getKeysBySection')->with($id);

        $this->controller->showKeys($id);
    }

    public function testShowKeysNotFound()
    {
        $id = 1;
        $this->keyRepository->expects($this->once())
            ->method('getKeysBySection')->with($id)
            ->will($this->throwException(new \Illuminate\Database\Eloquent\ModelNotFoundException()));

        $this->assertEquals(
            $this->controller->respondNotFound('Could not find key(s)'),
            $this->controller->showkeys($id)
        );
    }

    public function testShowKeysException()
    {
        $id = 1;

        $this->keyRepository->expects($this->once())
            ->method('getKeysBySection')
            ->will($this->throwException(new Exception));

        $this->assertEquals(
            $this->controller->respondInternalServerError('Could not show key(s)'),
            $this->controller->showKeys($id)
        );
    }

    public function testShowReport()
    {
        $id = 1;
        $questionSetId = 1;
        $this->evaluationRepository->expects($this->once())
            ->method('getEvaluationsBySectionAndQuestionSet')->with($id, $questionSetId);

        $this->controller->showReport($id, $questionSetId);


    }

    public function testShowReportNotFound()
    {
        $id = 1;
        $questionSetId = 1;
        $this->evaluationRepository->expects($this->once())
            ->method('getEvaluationsBySectionAndQuestionSet')->with($id, $questionSetId)
            ->will($this->throwException(new \Illuminate\Database\Eloquent\ModelNotFoundException()));

        $this->assertEquals(
            $this->controller->respondNotFound('Could not find report'),
            $this->controller->showReport($id, $questionSetId)
        );
    }

    public function testShowReportException()
    {
        $id = 1;
        $questionSetId = 1;
        $this->evaluationRepository->expects($this->once())
            ->method('getEvaluationsBySectionAndQuestionSet')->with($id, $questionSetId)
            ->will($this->throwException(new Exception));

        $this->assertEquals(
            $this->controller->respondInternalServerError('Could not show report'),
            $this->controller->showReport($id, $questionSetId)
        );
    }
}
