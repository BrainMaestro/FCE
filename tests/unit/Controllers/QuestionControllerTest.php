<?php

/* [Created by SkaeX @ 2016-03-07 12:27:23]
*/

use Fce\Http\Controllers\QuestionController;
use Fce\Http\Requests\QuestionRequest;
use Fce\Repositories\Contracts\QuestionRepository;

class QuestionControllerTest extends TestCase
{
    protected $repository;
    protected $controller;

    public function setUp()
    {
        parent::setUp();
        $this->repository = $this->getMockBuilder(QuestionRepository::class)->getMock();
        $this->controller = new QuestionController($this->repository);
    }

    public function testIndex()
    {
        $this->repository->expects($this->once())
            ->method('getQuestions');

        $this->controller->index();
    }

    public function testShow()
    {
        $this->repository->expects($this->once())
            ->method('getQuestionById')->with(parent::ID);

        $this->controller->show(parent::ID);
    }

    public function testCreate()
    {
        $request = new QuestionRequest;

        $this->repository->expects($this->once())
            ->method('createQuestion')
            ->with($request->description, $request->category, $request->title);

        $this->controller->create($request);
    }
}
