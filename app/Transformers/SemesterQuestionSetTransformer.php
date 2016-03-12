<?php
/**
 * Created by BrainMaestro
 * Date: 12/3/2016
 * Time: 12:19 AM
 */

namespace Fce\Transformers;

use Illuminate\Database\Eloquent\Collection;
use League\Fractal\TransformerAbstract;

class SemesterQuestionSetTransformer extends TransformerAbstract
{
    /**
     * @param $questionSets
     * @return array
     */
    public function transform($questionSets)
    {
        if ($questionSets instanceof Collection) {
            return array_map(function ($questionSet) {

                return self::getDetails($questionSet);
            }, $questionSets->toArray());
        }

        return self::getDetails($questionSets);
    }

    /**
     * Get the relevant details from the question set.
     *
     * @param $questionSet
     * @return array
     */
    private static function getDetails($questionSet)
    {
        return [
            'id' => $questionSet['id'],
            'name' => $questionSet['name'],
            'evaluation_type' => $questionSet['pivot']['evaluation_type'],
            'status' => $questionSet['pivot']['status'],
        ];
    }
}