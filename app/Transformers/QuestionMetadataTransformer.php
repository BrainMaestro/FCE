<?php
/**
 * Created by PhpStorm.
 * User: Cheezzy Tenorz
 * Date: 10/18/2015
 * Time: 8:53 PM
 */

namespace app\Transformers;

use App\Models\QuestionMetadata;
use League\Fractal\TransformerAbstract;

class QuestionMetadataTransformer extends TransformerAbstract
{
    public function transform(QuestionMetadata $questionMetadata)
    {
        return [
            'id' => $questionMetadata->id,
            'question_id' => $questionMetadata->question_id,
            'number' => $questionMetadata->number,
            'category' => $questionMetadata->cateory,
            'title' => $questionMetadata->title,
            'description' => $questionMetadata->description,
            'created_at' => $questionMetadata->created_at,
            'updated_at' => $questionMetadata->updated_at,
            'deleted_at' => $questionMetadata->deleted_at
        ];
    }
}