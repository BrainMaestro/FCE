<?php
/**
 * Created by BrainMaestro
 * Date: 10/2/2016
 * Time: 11:09 PM
 */

namespace Fce\Repositories\Contracts;

interface CommentRepository
{
    public function getComments($sectionId, $questionSetId);

    public function createComment($sectionId, $questionSetId, $comment);
}
