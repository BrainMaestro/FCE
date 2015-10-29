<?php
/**
 * Created by PhpStorm.
 * User: Cheezzy Tenorz
 * Date: 10/29/2015
 * Time: 8:20 PM
 */

namespace Fce\Repositories;

use Fce\Models\Question;
use Fce\Models\QuestionSet;

class QuestionsRepository extends AbstractRepository implements IQuestionsRepository
{
    protected $question_set_model;
    protected $question_model;

    public function __construct(QuestionSet $questionSet, Question $question)
    {
        $this->question_set_model = $questionSet;
        $this->question_model = $question;
    }

    public function getQuestionsByQuestionSet($data, $question_set_id)
    {
        try {
            Paginator::currentPageResolver(
                function () use ($data) {
                    return $data['offset'];
                }
            );
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function createQuestionSetQuestions($data)
    {
        try {

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function createNewQuestionSetQuestions($data)
    {
        try {

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function createNewQuestionSetQuestionsBySetId($data, $question_set_id)
    {
        try {

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
