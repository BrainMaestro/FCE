<?php
/**
 * Created by PhpStorm.
 * User: Cheezzy Tenorz
 * Date: 10/18/2015
 * Time: 10:43 PM
 */

namespace app\Transformers;

use App\Models\Evaluation;
use League\Fractal\TransformerAbstract;

class EvaluationTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $availableIncludes = [
        'question'
    ];

    public function transform(Evaluation $evaluation)
    {
        return [
            'id' => (int) $evaluation->id,
            'section_id' => (int) $evaluation->section_id,
            'question_id' => (int) $evaluation->question_id,
            'question_metadata_id' => (int) $evaluation->question_metadata_id,
            'one' => (int) $evaluation->one,
            'two' => (int) $evaluation->two,
            'three' => (int) $evaluation->three,
            'four' => (int) $evaluation->four,
            'five' => (int) $evaluation->five,
            'comment' => (string) $evaluation->comment,
            'created_at' => $evaluation->created_at,
            'updated_at' => $evaluation->updated_at,
            'deleted_at' => $evaluation->deleted_at
        ];
    }

    /**
     * @param Evaluation $evaluation
     * @return \League\Fractal\Resource\Item
     */
    public function includeQuestion(Evaluation $evaluation)
    {
        $question = $evaluation->question;
        return $this->item($question, new QuestionTransformer);
    }
}