<?php
/**
 * Created by PhpStorm.
 * User: Cheezzy Tenorz
 * Date: 10/29/2015
 * Time: 7:26 PM
 */

namespace Fce\Repositories\Database;

use Carbon\Carbon;
use Fce\Models\Evaluation;
use Fce\Repositories\Contracts\EvaluationRepository;
use Fce\Repositories\Repository;
use Fce\Transformers\EvaluationTransformer;

class EloquentEvaluationRepository extends Repository implements EvaluationRepository
{

    /**
     * Create a new repository instance.
     *
     * @param Evaluation $model
     * @param EvaluationTransformer $transformer
     */
    public function __construct(Evaluation $model, EvaluationTransformer $transformer)
    {
        $this->model = $model;
        $this->transformer = $transformer;
    }

    /**
     * Get all evaluations by the section and question set they belong to.
     *
     * @param $sectionId
     * @param $questionSetId
     * @return array
     */
    public function getEvaluationsBySectionAndQuestionSet($sectionId, $questionSetId)
    {
        return $this->findBy([
            'section_id' => $sectionId,
            'question_set_id' => $questionSetId
        ], self::ALL);
    }

    /**
     * Get a single evaluation by the section, question set and question it belongs to.
     *
     * @param $sectionId
     * @param $questionSetId
     * @param $questionId
     * @return array
     */
    public function getEvaluationBySectionQuestionSetAndQuestion($sectionId, $questionSetId, $questionId)
    {
        return $this->findBy([
            'section_id' => $sectionId,
            'question_set_id' => $questionSetId,
            'question_id' => $questionId
        ], self::ONE);
    }

    /**
     * Create a new set of evaluations for the specified question and question set.
     *
     * @param $sectionId
     * @param array $questionSet
     * @return boolean
     */
    public function createEvaluations($sectionId, array $questionSet)
    {
        $questionSetId = $questionSet['id'];
        // Bulk insert does not insert timestamps, so we'll generate them ourselves
        $now = Carbon::now('utc');

        $attributes = array_map(function($question) use ($sectionId, $questionSetId, $now) {
            return [
                'section_id' => $sectionId,
                'question_set_id' => $questionSetId,
                'question_id' => $question['id'],
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }, $questionSet['questions']['data']);

        return $this->model->insert($attributes);
    }

    /**
     * Increments a field in the evaluation
     *
     * @param $id
     * @param $column
     * @return int
     */
    public function incrementEvaluation($id, $column)
    {
        return $this->model->findOrFail($id)->increment($column);
    }
}
