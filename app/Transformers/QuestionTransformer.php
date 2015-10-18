<?php
/**
 * Created by PhpStorm.
 * User: Cheezzy Tenorz
 * Date: 10/18/2015
 * Time: 8:30 PM
 */

namespace app\Transformers;

use App\Models\Question;
use League\Fractal\TransformerAbstract;

class QuestionTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $defaultIncludes = [
        'questionMetadata'
    ];

    /**
     * @param Question $question
     * @return array
     */
    public function transform(Question $question)
    {
        return [
            'id' => $question->id,
            'type' => $question->type,
            'created_at' => $question->created_at,
            'updated_at' => $question->updated_at,
            'deleted_at' => $question->deleted_at
        ];
    }

    /**
     * @param Question $question
     * @return \League\Fractal\Resource\Collection
     */
    public function includeQuestionMetadata(Question $question)
    {
        $questionMetadata = $question->questionMetadata;
        return $this->collection($questionMetadata, new QuestionMetadataTransformer);
    }
}