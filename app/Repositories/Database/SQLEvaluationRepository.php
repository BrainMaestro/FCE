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

class SQLEvaluationRepository extends Repository implements EvaluationRepository
{
    /**
     * The transformer registered on the repository.
     *
     * @var \League\Fractal\TransformerAbstract
     */
    protected static $transformer = EvaluationTransformer::class;

    /**
     * Get an instance of the registered model
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    protected function getModel()
    {
        return new Evaluation;
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
     * @return mixed
     */
    public function incrementEvaluation($id, $column)
    {
        // This is found so that the current column value can be retrieved
        $evaluationModel = $this->model->findOrFail($id);

        return $this->update($evaluationModel, [$column => $evaluationModel->$column + 1]);
    }
}
