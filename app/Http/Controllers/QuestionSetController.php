<?php

/* [Created by SkaeX @ 2016-03-09 07:10:39] */

namespace Fce\Http\Controllers;

use Fce\Http\Requests\QuestionSetRequest;
use Fce\Http\Requests\QuestionSetAddQuestionRequest;
use Fce\Repositories\Contracts\QuestionSetRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class QuestionSetController extends Controller
{
    protected $repository;

    public function __construct(QuestionSetRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        try {
            return $this->repository->getQuestionSets();
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound('Could not find any question sets');
        } catch (\Exception $e) {
            return $this->respondInternalServerError('Could not list questions sets');
        }
    }

    public function show($id)
    {
        try {
            return $this->repository->getQuestionSetById($id);
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound('Could not find question set');
        } catch (\Exception $e) {
            return $this->respondInternalServerError('Could not show question set');
        }
    }

    public function create(QuestionSetRequest $request)
    {
        try {
            return $this->respondCreated($this->repository->createQuestionSet($request->name));
        } catch (\Exception $e) {
            return $this->respondInternalServerError('Could not create question set');
        }
    }

    public function addQuestions(QuestionSetAddQuestionRequest $request, $id)
    {
        try {
            return $this->repository->addQuestions($id, $request->all());
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound('Could not find question set');
        } catch (\Exception $e) {
            return $this->respondInternalServerError('Could not add question(s) to question set');
        }
    }
}
