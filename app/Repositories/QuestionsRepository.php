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
use Fce\Transformers\QuestionSetTransformer;
use Illuminate\Pagination\Paginator;

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

            if (is_null($data['query'])) {
                $question_set = $this->question_set_model->orderBy($data['sort'].$data['order'])
                    ->paginate($data['limit']);
            } else {
                $question_set = $this->question_set_model->where('crn', 'like', '%'.$data['query'].'%')
                    ->orderBy($data['sort'].$data['order'])
                    ->paginate($data['limit']);
            }

            if ($question_set->isEmpty()) {
                return null;
            } else {
                $question_set = self::setPaginationLinks($question_set, $data);
                return self::transform($question_set, new QuestionSetTransformer());
            }
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
