<?php
/**
 * Created by BrainMaestro
 * Date: 12/3/2016
 * Time: 12:19 AM
 */

namespace Fce\Transformers;

use League\Fractal\TransformerAbstract;

class SemesterQuestionSetTransformer extends TransformerAbstract
{
    /**
     * @param $questionSet
     * @return array
     */
    public function transform($questionSet)
    {
        return [
            'id' => $questionSet['id'],
            'name' => $questionSet['name'],
            'evaluation_type' => $questionSet['pivot']['evaluation_type'],
            'status' => $questionSet['pivot']['status'],
        ];
    }
}