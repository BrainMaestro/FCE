<?php

/* [Created by SkaeX @ 2016-03-07 21:36:03]  */

use Fce\Http\Controllers\QuestionSetController;
use Fce\Http\Requests\QuestionSetRequest;
use Fce\Repositories\Contracts\QuestionSetRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class QuestionSetControllerTest extends TestCase
{
    protected $request;
    protected $repository;
    protected $controller;

    public function setUp()
    {
        parent::setUp();
        $this->request = new QuestionSetRequest;
        $this->repository = $this->getMockBuilder(QuestionSetRepository::class)->getMock();
        $this->controller = new QuestionSetController($this->request, $this->repository);
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
        $this->repository->expects($this->once())
            ->method('createQuestionSet')
            ->with($this->request->name);

        $this->controller->create($this->request);
    }

    public function testCreateException()
    {
        $this->repository->expects($this->once())
            ->method('createQuestionSet')
            ->with($this->request->name)
            ->will($this->throwException(new Exception));

        $this->assertEquals(
            $this->controller->respondInternalServerError('Could not create question set'),
            $this->controller->create($this->request)
        );
    }
    public function testAddQuestions()
    {
        $this->repository->expects($this->once())
            ->method('addQuestions')
            ->with(parent::ID, $this->request->all());

        $this->controller->addQuestions(parent::ID);
    }

    public function testAddQuestionsNotFoundException()
    {
        $this->repository->expects($this->once())
            ->method('addQuestions')
            ->with(parent::ID, $this->request->all())
            ->will($this->throwException(new ModelNotFoundException));

        $this->assertEquals(
            $this->controller->respondNotFound('Could not find question set'),
            $this->controller->addQuestions(parent::ID)
        );
    }

    public function testAddQuestionsException()
    {
        $this->repository->expects($this->once())
            ->method('addQuestions')
            ->with(parent::ID, $this->request->all())
            ->will($this->throwException(new Exception));

        $this->assertEquals(
            $this->controller->respondInternalServerError('Could not add question(s) to question set'),
            $this->controller->addQuestions(parent::ID)
        );
    }
}
