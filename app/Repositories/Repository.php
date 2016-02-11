<?php
/**
 * Created by PhpStorm.
 * User: Cheezzy Tenorz
 * Date: 10/17/2015
 * Time: 2:36 PM
 */

namespace Fce\Repositories;

use Fce\Providers\Fractal;
use League\Fractal\Manager as FractalManager;
use Illuminate\Support\Facades\Input;

abstract class Repository
{
    /**
     * The model registered on the repository.
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * The transformer registered on the repository.
     *
     * @var \League\Fractal\TransformerAbstract
     */
    protected $transformer;

    public function __construct()
    {
        $this->model = $this->getModel();
        $this->transformer = $this->getTransformer();
    }

    /**
     * Get an instance of the registered model
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    abstract protected function getModel();

    /**
     * Get an instance of the registered transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    abstract protected function getTransformer();

    /**
     * Create and persist a new model
     *
     * @param array $attributes
     * @return static
     */
    protected function create(array $attributes = [])
    {
        return $this->model->create($attributes);
    }

    /**
     * Find a model by its id
     *
     * @param $id
     * @param array $columns
     * @return mixed
     */
    protected function find($id, array $columns = ['*'])
    {
        return $this->model->findOrFail($id, $columns);
    }

    protected function findBy($field, $value, array $columns = ['*'], array $with = [], $limit = 15)
    {
        return $this->model->where($field, 'like', '%' . $value . '%')
                            ->with($with)
                            ->paginate($limit, $columns);
    }

    /**
     * Update the model in the database
     *
     * @param $id
     * @param array $attributes
     * @return mixed
     */
    protected function update($id, array $attributes)
    {
        return $this->model->findOrFail($id)->update($attributes);
    }

    /**
     * @return Fractal
     */
    protected function setFractal() // TODO Add method description in doc
    {
        $fractalManager = new FractalManager();
        $includes = Input::get('include');

        if ($includes) {
            $fractalManager = $fractalManager->parseIncludes($includes);
        }

        return new Fractal($fractalManager);
    }

    /**
     * Transforms the model
     *
     * @param $dataModel
     * @return mixed
     * @throws \Exception
     */
    protected function transform($dataModel)
    {
        $method = $this->getTransformMethod($dataModel);

        return $this->setFractal()->$method($dataModel, $this->transformer)->toArray();
    }

    /**
     * Gets the transform method based on the type of model being passed
     *
     * @param $dataModel
     * @return string
     * @throws \Exception
     */
    private function getTransformMethod($dataModel)
    {
        switch (get_class($dataModel)) {
            case \Illuminate\Database\Eloquent\Collection::class:
                return 'respondWithCollection';

            case \Illuminate\Pagination\LengthAwarePaginator::class:
                return 'respondWithPaginatedCollection';

            case \Illuminate\Database\Eloquent\Model::class:
                return 'respondWithItem';

            default:
                throw new \InvalidArgumentException('Could not transform provided model');
        }
    }
}
