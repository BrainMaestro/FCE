<?php
/**
 * Created by BrainMaestro
 * Date: 17/2/2016
 * Time: 9:50 PM
 */

namespace Fce\Transformers;

use App;
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
}