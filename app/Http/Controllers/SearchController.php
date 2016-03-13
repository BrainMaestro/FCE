<?php

namespace Fce\Http\Controllers;

use Fce\Http\Requests\SearchRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SearchController extends Controller
{
    protected $request;
    protected $model;
    protected $transformer;
    protected $repository;

//    public function __construct(SearchRequest $request)
//    {
//        $this->request = $request;
//    }

    public function index(SearchRequest $request)
    {
        try {
            $this->request = $request;
            $this->setRepository($this->request->model);

            return $this->repository->all();
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound("Could not find any " . $this->request->model . "s, that meet the search criteria");
        } catch (\Throwable $t) {
            return $this->respondUnprocessable("Model doesn't exist or can't be searched");
        } catch (\Exception $e) {
            return $this->respondInternalServerError("Could not complete search, an error occurred");
        }
    }

    private function setRepository($model)
    {
            $this->model = "Fce\\Models\\" . ucfirst($model);
            $this->transformer = "Fce\\Transformers\\" . ucfirst($model) . "Transformer";
            $this->repository = "Fce\\Repositories\\Database\\Eloquent" . ucfirst($model) . "Repository";

            $this->model = new $this->model();
            $this->transformer = new $this->transformer();
            $this->repository = new $this->repository($this->model, $this->transformer);
    }
}
