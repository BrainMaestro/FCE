<?php
/**
 * Created by PhpStorm.
 * User: Cheezzy Tenorz
 * Date: 10/18/2015
 * Time: 8:53 PM
 */

namespace App\Transformers;

use App\Models\Question;
use League\Fractal\TransformerAbstract;

class QuestionTransformer extends TransformerAbstract
{
    public function transform(Question $question)
    {
        return [
            'id' => (int) $question->id,
            'category' => $question->cateory,
            'title' => $question->title,
            'description' => $question->description,
        ];
    }
}