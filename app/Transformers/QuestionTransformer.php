<?php
/**
 * Created by PhpStorm.
 * User: Cheezzy Tenorz
 * Date: 10/18/2015
 * Time: 8:53 PM
 */

namespace Fce\Transformers;

use Fce\Models\Question;
use League\Fractal\TransformerAbstract;

class QuestionTransformer extends TransformerAbstract
{
    public function transform(Question $question)
    {
        $attributes = [
            'id' => (int) $question->id,
            'category' => $question->category,
            'title' => $question->title,
            'description' => $question->description
        ];

        if (isset($question->pivot)) {
            array_merge($attributes, ['position' => $question->pivot->position]);
        }

        return $attributes;
    }
}
