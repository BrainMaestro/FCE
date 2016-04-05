<?php

namespace Fce\Http\Controllers;

use Fce\Http\Requests\SearchRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SearchController extends Controller
{
    protected $repository;

    /**
     * Search the specified model with the input query.
     *
     * @param SearchRequest $request
     * @return array
     */
    public function index(SearchRequest $request)
    {
        $this->setRepository($request->model);

        return $this->repository->all();
    }

    /**
     * Set the repository to use for searching.
     *
     * @param $model
     */
    protected function setRepository($model)
    {
        // Uses laravel's service container to resolve the specified
        // repository interface into a concrete implementation.
        $this->repository = app('Fce\\Repositories\\Contracts\\' . ucfirst($model) . 'Repository');
    }
}
