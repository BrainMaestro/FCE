<?php
/**
 * Created by PhpStorm.
 * User: Cheezzy Tenorz
 * Date: 10/17/2015
 * Time: 2:36 PM.
 */
namespace Fce\Repositories;

use Fce\Utility\Transformable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Input;

abstract class Repository
{
    use Transformable;

    /**
     * Constants for pagination.
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
     * @return array
     */
    public function all()
    {
        $filtered = $this->search();
        $paginated = $filtered->paginate($this->getLimit(), $this->getColumns(), 'page', $this->getPage());

        if ($paginated->isEmpty()) {
            throw (new ModelNotFoundException)->setModel(get_class($this->model));
        }

        return $this->transform($paginated);
    }

    /**
     * Find a model by its id.
     *
     * @param $id
     * @return array
     * @throws ModelNotFoundException
     */
    protected function find($id)
    {
        return $this->transform($this->model->findOrFail($id, $this->getColumns()));
    }

    /**
     * Finds and returns one, all or a paginated list of the models
     * with the specified parameters (field and value).
     *
     * @param array $params
     * @param $count
     * @param array $with
     * @return array
     * @throws ModelNotFoundException
     */
    protected function findBy(array $params, $count = self::PAGINATE, array $with = [])
    {
        $columns = $this->getColumns();
        $items = $this->filter($params);

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

        if (is_null($items) || ! count($items)) {
            throw (new ModelNotFoundException)->setModel(get_class($this->model));
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
     * @return bool
     * @throws ModelNotFoundException
     */
    protected function update($id, array $attributes)
    {
        if (count($attributes) == 0) {
            return false;
        }

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
    private function search()
    {
        $query = $this->getQuery();

        if (is_null($query)) {
            return $this->model;
        }

        $attributes = [];
        foreach (explode('|', $query) as $parameter) {
            list($column, $value) = explode(':', $parameter);
            $attributes[$column] = $value;
        }

        // Removes columns that are not in the model's accessible columns
        $attributes = array_only($attributes, $this->model->getFillable());

        return $this->filter($attributes);
    }

    /**
     * Perform filter with the specified parameters.
     *
     * @param array $params
     * @return mixed
     */
    private function filter(array $params)
    {
        return $this->model->where(function ($query) use ($params) {
            foreach ($params as $column => $value) {
                $query->where($column, 'LIKE', '%' . $value . '%');
            }
        });
    }
}
