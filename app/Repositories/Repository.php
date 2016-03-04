<?php
/**
 * Created by PhpStorm.
 * User: Cheezzy Tenorz
 * Date: 10/17/2015
 * Time: 2:36 PM
 */

namespace Fce\Repositories;

use Fce\Traits\Transformable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Input;

abstract class Repository
{
    use Transformable;

    /**
     * Constants for pagination
     */
    const ALL = 'all';
    const ONE = 'one';
    const PAGINATE = 'paginate';

    /**
     * The model registered on the repository.
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * Return a paginated list of all the available models.
     *
     * @param array $columns
     * @return array
     */
    public function all(array $columns = ['*'])
    {
        $filtered = $this->filter();
        $paginated = $filtered->paginate($this->getLimit(), $columns, 'page', $this->getPage());

        return $this->transform($paginated);
    }

    /**
     * Find a model by its id.
     *
     * @param $id
     * @param array $columns
     * @return array
     * @throws ModelNotFoundException
     */
    protected function find($id, array $columns = ['*'])
    {
        return $this->transform($this->model->findOrFail($id, $columns));
    }

    /**
     * Finds and returns one, all or a paginated list of the models
     * with the specified parameters (field and value).
     *
     * @param array $params
     * @param $count
     * @param array $columns
     * @param array $with
     * @return array
     * @throws ModelNotFoundException
     */
    protected function findBy(array $params, $count = self::PAGINATE, array $columns = ['*'], array $with = [])
    {
        // Model to use for the method chaining
        $items = $this->model;

        foreach ($params as $field => $value) {
            $items = $items->where($field, 'like', '%' . $value . '%');
        }

        if (count($with) > 0) {
            $items = $items->with($with);
        }

        // Returns one, all or a paginated list of items
        switch ($count) {
            case self::ONE:
                $items = $items->first($columns);
                break;

            case self::ALL:
                $items = $items->get($columns);
                break;

            case self::PAGINATE:
                $items = $items->paginate($this->getLimit(), $columns, 'page', $this->getPage());
        }

        if (is_null($items) || !count($items)) {
            throw new ModelNotFoundException('Could not find the specified model');
        }

        return $this->transform($items);
    }

    /**
     * Create and persist a new model.
     *
     * @param array $attributes
     * @return array
     * @throws \Illuminate\Database\QueryException
     */
    protected function create(array $attributes)
    {
        return $this->transform($this->model->create($attributes));
    }

    /**
     * Update the model in the database.
     *
     * @param $id
     * @param array $attributes
     * @return boolean
     * @throws ModelNotFoundException
     */
    protected function update($id, array $attributes)
    {
        return $this->model->findOrFail($id)->update($attributes);
    }

    /**
     * Get the page specified in the url string.
     *
     * @return int
     */
    private function getPage()
    {
        return Input::get('page', 1);
    }

    /**
     * Get the limit specified in the url string.
     *
     * @return int
     */
    private function getLimit()
    {
        return Input::get('limit', 10);
    }

    /**
     * Get the query specified in the url string.
     *
     * @return int
     */
    private function getQuery()
    {
        return Input::get('query', null);
    }

    /**
     * Return collection of result based on query parameters.
     *
     * @return mixed
     */
    private function filter()
    {
        $query = $this->getQuery();

        if (is_null($query)) {
            return $this->model;
        }

        $attributes = [];
        foreach (explode("|", $query) as $parameter) {
            list($column, $value) = explode(":=", $parameter);
            $attributes[$column] = $value;
        }

        // Removes columns that are not in the model's accessible columns
        $attrtibutes = array_only($attributes, $this->model->getFillable());

        $result = $this->model->where(function ($query) use ($attributes) {
            foreach ($attributes as $column => $value) {
                $query->where($column, 'LIKE', '%'. $value .'%');
            }
        });

        return $result;
    }
}
