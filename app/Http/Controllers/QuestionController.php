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
        try {
            return $this->repository->getQuestions();
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound('Could not find any questions');
        } catch (\Exception $e) {
            return $this->respondInternalServerError('Could not list questions');
        }
    }

    /**
     * Get a specific question by id.
     * 
     * @param $id
     * @return array
     */
    public function show($id)
    {
        try {
            return $this->repository->getQuestionById($id);
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound('Could not find question');
        } catch (\Exception $e) {
            return $this->respondInternalServerError('Could not show question');
        }
    }

    /**
     * Create a new question.
     * 
     * @param QuestionRequest $request
     * @return mixed
     */
    public function create(QuestionRequest $request)
    {
        try {
            return $this->respondCreated(
                $this->repository->createQuestion($request->description, $request->category, $request->title)
            );
        } catch (\Exception $e) {
            return $this->respondInternalServerError('Could not create question');
        }
    }
}
