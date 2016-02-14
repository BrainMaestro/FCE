<?php
/**
 * Created by PhpStorm.
 * User: Cheezzy Tenorz
 * Date: 10/17/2015
 * Time: 2:36 PM
 */

namespace Fce\Repositories;

use Fce\Providers\Fractal;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Input;
use League\Fractal\Manager as FractalManager;

abstract class Repository
{
    /**
     * The model registered on the repository.
     *
     * @var Model
     */
    protected $model;

    /**
     * The transformer registered on the repository.
     *
     * @var \League\Fractal\TransformerAbstract
     */
    protected $transformer;

    /**
     * Create a new repository instance
     */
    public function __construct()
    {
        $this->model = $this->getModel();
        $this->transformer = $this->getTransformer();
    }

    /**
     * Get an instance of the registered model
     *
     * @return Model
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
     * @throws \InvalidArgumentException
     */
    protected function create(array $attributes)
    {
        try {
            return $this->model->create($attributes);
        } catch(\Exception $e) {
            throw new \InvalidArgumentException('Wrong or incomplete set of attributes provided');
        }
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
        return self::transform($this->model->findOrFail($id, $columns));
    }

    /**
     * Finds and returns one, all or a paginated list of the models with the specified field and value
     *
     * @param $field
     * @param $value
     * @param int $limit
     * @param int $page
     * @param array $columns
     * @param array $with
     * @return mixed
     * @throws \InvalidArgumentException
     * @throws ModelNotFoundException
     */
    protected function findBy($field, $value, $limit = 15, $page = 1, array $columns = ['*'], array $with = [])
    {
        // Allows the calling method to pass multiple fields and values
        if (is_array($field) && is_array($value)) {
            if (count($field) != count($value)) {
                throw new \InvalidArgumentException('Number of specified fields and values do not match');
            }

            $items = $this->model;

            for ($i = 0; $i < count($field); $i++) {
                $items = $items->where($field[$i], 'like', '%' . $value[$i] . '%')->with($with);
            }
        } else {
            $items = $this->model->where($field, 'like', '%' . $value . '%')->with($with);
        }

        // Returns one, all or a paginated list of items
        switch ($limit) {
            case 'one':
                $items = $items->first($columns);
                break;

            case 'all':
                $items = $items->get($columns);
                break;

            default:
                $items = $items->paginate($limit, $columns, 'page', $page);
        }

        if (is_null($items) || !count($items)) {
            throw new ModelNotFoundException('Could not find the specified model');
        }

        return self::transform($items);
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
        // Allows the calling method to pass the model directly if it has already been found
        // to prevent another database lookup. This might be removed eventually
        if ($id instanceof Model) {
            $model = $id;
            return $model->update($attributes);
        }

        return $this->model->findOrFail($id)->update($attributes);
    }

    /**
     * Parses the includes specified in the input
     *
     * @return Fractal
     */
    final protected static function setFractal()
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
    final public static function transform($dataModel)
    {
        $method = self::getTransformMethod($dataModel);

        return self::setFractal()->$method($dataModel, (new static)->transformer)->toArray();
    }

    /**
     * Gets the transform method based on the type of model being passed
     *
     * @param $dataModel
     * @return string
     * @throws \InvalidArgumentException
     */
    final protected static function getTransformMethod($dataModel)
    {
        if ($dataModel instanceof Collection) {
            return 'respondWithCollection';
        } elseif ($dataModel instanceof LengthAwarePaginator) {
            return 'respondWithPaginatedCollection';
        } elseif ($dataModel instanceof Model) {
            return 'respondWithItem';
        } else {
            throw new \InvalidArgumentException('Could not transform provided model');
        }
    }
}
