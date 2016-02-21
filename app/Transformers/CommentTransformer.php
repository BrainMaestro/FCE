<?php
/**
 * Created by PhpStorm.
 * User: Cheezzy Tenorz
 * Date: 2/11/2016
 * Time: 8:42 PM
 */

namespace Fce\Transformers;

use Fce\Models\Comment;
use League\Fractal\TransformerAbstract;

class CommentTransformer extends TransformerAbstract
{
    /**
     * @param Comment $comment
     * @return array
     */
    public function transform(Comment $comment)
    {
        return $comment->comment;
    }
}
