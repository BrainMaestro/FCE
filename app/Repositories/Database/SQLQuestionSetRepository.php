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

class SQLQuestionSetRepository extends Repository implements QuestionSetRepository
{
    /**
     * The transformer registered on the repository.
     *
     * @var \League\Fractal\TransformerAbstract
     */
    protected static $transformer = QuestionSetTransformer::class;

    /**
     * Get an instance of the registered model
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    protected function getModel()
    {
        return new QuestionSet;
    }

    public function getQuestionSets()
    {
        return $this->all();
    }

    public function getQuestionSetById($id)
    {
        return $this->find($id);
    }

    public function createQuestionSet($attributes)
    {
        return $this->create($attributes);
    }
}