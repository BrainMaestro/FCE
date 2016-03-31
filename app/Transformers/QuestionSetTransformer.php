<?php
/**
 * Created by PhpStorm.
 * User: Cheezzy Tenorz
 * Date: 10/18/2015
 * Time: 8:30 PM.
 */
namespace Fce\Transformers;

use Fce\Models\QuestionSet;
use League\Fractal\TransformerAbstract;

class QuestionSetTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $availableIncludes = [
        'questions',
    ];

    /**
     * @param QuestionSet $questionSet
     * @return array
     */
    public function transform(QuestionSet $questionSet)
    {
        $attributes = [
            'id' => (int) $questionSet->id,
            'name' => $questionSet->name,
        ];

        if (isset($questionSet->pivot)) {
            $attributes = array_merge($attributes, [
                'evaluation_type' => $questionSet->pivot->evaluation_type,
                'status' => $questionSet->pivot->status,
            ]);
        }

        return $attributes;
    }

    /**
     * @param QuestionSet $questionSet
     * @return \League\Fractal\Resource\Collection
     */
    public function includeQuestions(QuestionSet $questionSet)
    {
        return $this->collection($questionSet->questions, new QuestionTransformer);
    }
}
