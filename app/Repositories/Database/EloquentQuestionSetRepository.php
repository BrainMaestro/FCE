<?php
/**
 * Created by BrainMaestro
 * Date: 22/2/2016
 * Time: 12:04 PM
 */

namespace Fce\Repositories\Database;

use Fce\Models\QuestionSet;
use Fce\Repositories\Contracts\QuestionSetRepository;
use Fce\Repositories\Repository;
use Fce\Transformers\QuestionSetTransformer;

class EloquentQuestionSetRepository extends Repository implements QuestionSetRepository
{
    /**
     * The transformer registered on the repository.
     *
     * @var \League\Fractal\TransformerAbstract
     */
    protected static $transformer = QuestionSetTransformer::class;

    /**
     * Get an instance of the registered model.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    protected function getModel()
    {
        return new QuestionSet;
    }

    /**
     * Get all question sets.
     *
     * @return array
     */
    public function getQuestionSets()
    {
        return $this->all();
    }

    /**
     * Get a single question set by its id.
     *
     * @param $id
     * @return array
     */
    public function getQuestionSetById($id)
    {
        return $this->find($id);
    }

    /**
     * Create a new question set from the specified attributes.
     *
     * @param $attributes
     * @return array
     */
    public function createQuestionSet($attributes)
    {
        return $this->create($attributes);
    }

    /**
     * Add questions to the question set.
     *
     * @param $id
     * @param array $questionIds
     * @return array
     */
    public function addQuestions($id, array $questionIds)
    {
        return $this->model->findOrFail($id)->questions()->attach($questionIds);
    }
}