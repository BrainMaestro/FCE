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

    public function index(SearchRequest $request)
    {
        try {
            $this->request = $request;
            $this->setRepository($this->request->model);

            return $this->repository->all();
        } catch (ModelNotFoundException $m) {
            return $this->respondNotFound("Could not find any " . $this->request->model . "s, that meet the search criteria");
        } catch (\ReflectionException $r) {
            return $this->respondUnprocessable("Model doesn't exist or can't be searched");
        } catch (\Exception $e) {
            return $this->respondInternalServerError("Could not complete search, an error occurred");
        }
    }

    protected function setRepository($model)
    {
            $this->model = "Fce\\Models\\" . ucfirst($model);
            $this->transformer = "Fce\\Transformers\\" . ucfirst($model) . "Transformer";
            $this->repository = "Fce\\Repositories\\Database\\Eloquent" . ucfirst($model) . "Repository";

            if (!class_exists($this->repository)) {
                throw new \ReflectionException('Class does not exist');
            }

            $this->model = new $this->model();
            $this->transformer = new $this->transformer();
            $this->repository = new $this->repository($this->model, $this->transformer);
    }
}
