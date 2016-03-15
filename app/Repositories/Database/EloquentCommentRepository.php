<?php
/**
 * Created by PhpStorm.
 * User: Cheezzy Tenorz
 * Date: 10/29/2015
 * Time: 7:26 PM
 */

namespace Fce\Repositories\Database;

use Fce\Models\Comment;
use Fce\Repositories\Contracts\CommentRepository;
use Fce\Repositories\Repository;
use Fce\Transformers\CommentTransformer;

class EloquentCommentRepository extends Repository implements CommentRepository
{

    /**
     * Create a new repository instance.
     *
     * @param Comment $model
     * @param CommentTransformer $transformer
     */
    public function __construct(Comment $model, CommentTransformer $transformer)
    {
        $this->model = $model;
        $this->transformer = $transformer;
    }

    /**
     * Get all comments by the section and question set they belong to.
     *
     * @param $sectionId
     * @param $questionSetId
     * @return array
     */
    public function getComments($sectionId, $questionSetId)
    {
        return $this->findBy([
            'section_id' => $sectionId,
            'question_set_id' => $questionSetId
        ], self::ALL);
    }

    /**
     * Create a new comment from the specified attributes.
     *
     * @param $sectionId
     * @param $questionSetId
     * @param $questionId
     * @return array
     */
    public function createComment($sectionId, $questionSetId, $comment)
    {
        return $this->create([
            'section_id' => $sectionId,
            'question_set_id' => $questionSetId,
            'comment' => $comment,
        ]);
    }
}
