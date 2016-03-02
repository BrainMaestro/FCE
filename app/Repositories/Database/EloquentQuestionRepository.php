<?php
/**
 * Created by PhpStorm.
 * User: Cheezzy Tenorz
 * Date: 10/29/2015
 * Time: 8:20 PM
 */

namespace Fce\Repositories\Database;

use Fce\Models\Question;
use Fce\Repositories\Contracts\QuestionRepository;
use Fce\Repositories\Repository;
use Fce\Transformers\QuestionTransformer;

class EloquentQuestionRepository extends Repository implements QuestionRepository
{
    /**
     * Create a new repository instance.
     *
     * @param Question $model
     * @param QuestionTransformer $transformer
     */
    public function __construct(Question $model, QuestionTransformer $transformer)
    {
        $this->model = $model;
        $this->transformer = $transformer;
    }

    /**
     * Get all questions.
     *
     * @return array
     */
    public function getQuestions()
    {
        return $this->all();
    }

    /**
     * Get a single question by its id.
     *
     * @param $id
     * @return array
     */
    public function getQuestionById($id)
    {
        return $this->find($id);
    }

    /**
     * Create a new question from the specified attributes.
     *
     * @param $description
     * @param $category
     * @param $title
     * @return array
     */
    public function createQuestion($description, $category = null, $title = null)
    {
        return $this->create([
            'description' => $description,
            'category' => $category,
            'title' => $title,
        ]);
    }
}
