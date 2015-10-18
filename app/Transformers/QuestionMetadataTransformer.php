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
            'id' => (int) $questionMetadata->id,
            'question_id' => (int) $questionMetadata->question_id,
            'number' => (int) $questionMetadata->number,
            'category' => (string) $questionMetadata->cateory,
            'title' => (string) $questionMetadata->title,
            'description' => (string) $questionMetadata->description,
            'created_at' => $questionMetadata->created_at,
            'updated_at' => $questionMetadata->updated_at,
            'deleted_at' => $questionMetadata->deleted_at
        ];
    }
}