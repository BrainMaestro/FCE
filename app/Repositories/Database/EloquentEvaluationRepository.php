<?php
/**
 * Created by PhpStorm.
 * User: Cheezzy Tenorz
 * Date: 10/29/2015
 * Time: 7:26 PM
 */

namespace Fce\Repositories\Database;

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
     * Gets all evaluations by the section and question set they belong to
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
        ], 'all');
    }

    /**
     * Get a single evaluation by the section, question set and question it belongs to
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
        ], 'one');
    }

    /**
     * Creates a new evaluation from the specified attributes
     *
     * @param array $attributes
     * @return static
     */
    public function createEvaluation(array $attributes)
    {
        return $this->create($attributes);
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
