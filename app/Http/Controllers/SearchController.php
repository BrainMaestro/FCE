<?php

namespace Fce\Http\Controllers;

use Fce\Http\Requests\SearchRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SearchController extends Controller
{
    protected $repository;

    public function index(SearchRequest $request)
    {
        try {
            $this->setRepository($request->model);

            return $this->repository->all();
        } catch (ModelNotFoundException $m) {
            return $this->respondNotFound('Could not find any ' . $request->model . 's, that meet the search criteria');
        } catch (\ReflectionException $r) {
            return $this->respondUnprocessable('Model does not exist or cannot be searched');
        } catch (\Exception $e) {
            return $this->respondInternalServerError('Could not complete search, an error occurred');
        }
    }

    protected function setRepository($model)
    {
        $this->repository = app('Fce\\Repositories\\Contracts\\' . ucfirst($model) . 'Repository');
    }
}
