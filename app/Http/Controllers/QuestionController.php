<?php

namespace Fce\Http\Controllers;

use Fce\Http\Requests\QuestionRequest;
use Fce\Repositories\Contracts\QuestionRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class QuestionController extends Controller
{
    protected $repository;

    public function __construct(QuestionRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get all questions.
     *
     * @return array
     */
    public function index()
    {
        return $this->repository->getQuestions();
    }

    /**
     * Get a specific question by id.
     *
     * @param $id
     * @return array
     */
    public function show($id)
    {
        return $this->repository->getQuestionById($id);
    }

    /**
     * Create a new question.
     *
     * @param QuestionRequest $request
     * @return mixed
     */
    public function create(QuestionRequest $request)
    {
        return $this->respondCreated(
            $this->repository->createQuestion($request->description, $request->category, $request->title)
        );
    }
}
