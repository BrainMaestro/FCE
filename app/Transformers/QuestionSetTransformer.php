<?php
/**
 * Created by PhpStorm.
 * User: Cheezzy Tenorz
 * Date: 10/18/2015
 * Time: 8:30 PM
 */

namespace Fce\Transformers;

use Fce\Models\QuestionSet;
use League\Fractal\TransformerAbstract;

class QuestionSetTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $defaultIncludes = [
        'questions'
    ];

    /**
     * @param QuestionSet $questionSet
     * @return array
     */
    public function transform(QuestionSet $questionSet)
    {
        return [
            'id' => (int) $questionSet->id,
            'name' => $questionSet->name
        ];
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
