<?php

/* [Created by SkaeX @ 2016-03-07 21:36:03]  */

use Fce\Http\Controllers\QuestionSetController;
use Fce\Http\Requests\QuestionSetRequest;
use Fce\Http\Requests\QuestionSetAddQuestionRequest;
use Fce\Repositories\Contracts\QuestionSetRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class QuestionSetControllerTest extends TestCase
{
    protected $repository;
    protected $controller;

    public function setUp()
    {
        parent::setUp();
        $this->repository = $this->getMockBuilder(QuestionSetRepository::class)->getMock();
        $this->controller = new QuestionSetController($this->repository);
    }

    public function testIndex()
    {
        $this->repository->expects($this->once())
            ->method('getQuestionSets');

        $this->controller->index();
    }

    public function testIndexException()
    {
        $this->repository->expects($this->once())
            ->method('getQuestionSets')
            ->will($this->throwException(new Exception));

        $this->assertEquals(
            $this->controller->respondInternalServerError('Could not list questions sets'),
            $this->controller->index()
        );
    }

    public function testIndexNotFoundException()
    {
        $this->repository->expects($this->once())
            ->method('getQuestionSets')
            ->will($this->throwException(new ModelNotFoundException));

        $this->assertEquals(
            $this->controller->respondNotFound('Could not find any question sets'),
            $this->controller->index()
        );
    }

    public function testShow()
    {
        $this->repository->expects($this->once())
            ->method('getQuestionSetById')->with(parent::ID);

        $this->controller->show(parent::ID);
    }

    public function testShowNotFoundException()
    {
        $this->repository->expects($this->once())
            ->method('getQuestionSetById')->with(parent::ID)
            ->will($this->throwException(new ModelNotFoundException));

        $this->assertEquals(
            $this->controller->respondNotFound('Could not find question set'),
            $this->controller->show(parent::ID)
        );
    }

    public function testShowException()
    {
        $this->repository->expects($this->once())
            ->method('getQuestionSetById')->with(parent::ID)
            ->will($this->throwException(new Exception));

        $this->assertEquals(
            $this->controller->respondInternalServerError('Could not show question set'),
            $this->controller->show(parent::ID)
        );
    }

    public function testCreate()
    {
        $request = new QuestionSetRequest;

        $this->repository->expects($this->once())
            ->method('createQuestionSet')
            ->with($request->name);

        $this->controller->create($request);
    }

    public function testCreateException()
    {
        $request = new QuestionSetRequest;

        $this->repository->expects($this->once())
            ->method('createQuestionSet')
            ->with($request->name)
            ->will($this->throwException(new Exception));

        $this->assertEquals(
            $this->controller->respondInternalServerError('Could not create question set'),
            $this->controller->create($request)
        );
    }
    public function testAddQuestions()
    {
        $request = new QuestionSetAddQuestionRequest;
        $this->repository->expects($this->once())
            ->method('addQuestions')
            ->with(parent::ID, $request->all());

        $this->controller->addQuestions($request, parent::ID);
    }

    public function testAddQuestionsNotFoundException()
    {
        $request = new QuestionSetAddQuestionRequest;
        $this->repository->expects($this->once())
            ->method('addQuestions')
            ->with(parent::ID, $request->all())
            ->will($this->throwException(new ModelNotFoundException));

        $this->assertEquals(
            $this->controller->respondNotFound('Could not find question set'),
            $this->controller->addQuestions($request, parent::ID)
        );
    }

    public function testAddQuestionsException()
    {
    	$request = new QuestionSetAddQuestionRequest;
        $this->repository->expects($this->once())
            ->method('addQuestions')
            ->with(parent::ID, $request->all())
            ->will($this->throwException(new Exception));

        $this->assertEquals(
            $this->controller->respondInternalServerError('Could not add question(s) to question set'),
            $this->controller->addQuestions($request, parent::ID)
        );
    }
}
