<?php
/**
 * Created by PhpStorm.
 * User: Cheezzy Tenorz
 * Date: 10/29/2015
 * Time: 8:16 PM
 */

namespace Fce\Repositories;

interface IQuestionsRepository
{
    public function getQuestionsByQuestionSet($data, $question_set_id);

    public function createQuestionSetQuestions($data);

    public function createNewQuestionSetQuestions($data);

    public function createNewQuestionSetQuestionsBySetId($data, $question_set_id);

}
