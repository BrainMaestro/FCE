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
     * Create a new repository instance.
     *
     * @param QuestionSet $model
     * @param QuestionSetTransformer $transformer
     */
    public function __construct(QuestionSet $model, QuestionSetTransformer $transformer)
    {
        $this->model = $model;
        $this->transformer = $transformer;
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
     * @param array $questions
     * @return void
     */
    public function addQuestions($id, array $questions)
    {
        $this->model->findOrFail($id)->questions()->attach($questions);
    }
}