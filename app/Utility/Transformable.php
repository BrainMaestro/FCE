<?php
/**
 * Created by BrainMaestro
 * Date: 17/2/2016
 * Time: 9:50 PM.
 */
namespace Fce\Utility;

use Fce\Providers\Fractal;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Input;
use League\Fractal\Manager as FractalManager;

trait Transformable
{
    /**
     * The transformer registered on the repository.
     *
     * @var \League\Fractal\TransformerAbstract
     */
    protected $transformer;

    /**
     * Parses the includes specified in the input.
     *
     * @return Fractal
     */
    private static function setFractal()
    {
        $fractalManager = new FractalManager();
        $includes = Input::get('include');

        if ($includes) {
            $fractalManager = $fractalManager->parseIncludes($includes);
        }

        return new Fractal($fractalManager);
    }

    /**
     * Transforms the provided model.
     *
     * @param $model
     * @return mixed
     * @throws \InvalidArgumentException
     */
    public function transform($model)
    {
        $columns = $this->getColumns();

        if ($columns != ['*']) {
            return $this->transformWithColumns($model, $columns);
        }

        $method = self::getTransformMethod($model);

        return self::setFractal()->$method($model, $this->transformer)->toArray();
    }

    /**
     * Gets the transform method based on the type of model being passed.
     *
     * @param $model
     * @return string
     * @throws \InvalidArgumentException
     */
    private static function getTransformMethod($model)
    {
        if ($model instanceof Collection) {
            return 'respondWithCollection';
        } elseif ($model instanceof LengthAwarePaginator) {
            return 'respondWithPaginatedCollection';
        } elseif ($model instanceof Model) {
            return 'respondWithItem';
        } else {
            throw new \InvalidArgumentException('Could not transform provided model');
        }
    }

    /**
     * Get the columns specified in the url string.
     *
     * @return array
     */
    private function getColumns()
    {
        return explode(',', Input::get('columns', '*'));
    }

    /**
     * Transforms a model when specific columns are provided.
     * Removes columns that are not specified.
     *
     * @param $model
     * @param $columns
     * @return array
     */
    private function transformWithColumns($model, $columns)
    {
        if ($model instanceof Model) {
            return [
                'data' => array_only($model->toArray(), $columns),
            ];
        }

        return [
            'data' => array_map(function ($item) use ($columns) {
                return array_only($item, $columns);
            }, $model->toArray()['data']),
        ];
    }
}
