<?php

/* [Created by SkaeX @ 2016-03-09 07:10:39] */

namespace Fce\Http\Controllers;

use Fce\Http\Requests\QuestionSetRequest;
use Fce\Repositories\Contracts\QuestionSetRepository;

class QuestionSetController extends Controller
{
    protected $request;
    protected $repository;

    public function __construct(QuestionSetRequest $request, QuestionSetRepository $repository)
    {
        $this->request = $request;
        $this->repository = $repository;
    }

    /**
     * Get all question sets.
     *
     * @return array
     */
    public function index()
    {
        return $this->repository->getQuestionSets();
    }

    /**
     * Get a specific question set by id.
     *
     * @param $id
     * @return array
     */
    public function show($id)
    {
        return $this->repository->getQuestionSetById($id);
    }

    /**
     * Create a new question set.
     *
     * @return array
     */
    public function create()
    {
        return $this->respondCreated($this->repository->createQuestionSet($this->request->name));
    }

    /**
     * Add questions to a question set.
     *
     * @param $id
     * @return array
     */
    public function addQuestions($id)
    {
        return $this->repository->addQuestions($id, $this->request->all());
    }
}
