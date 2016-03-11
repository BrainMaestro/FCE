<?php
use Fce\Repositories\Database\EloquentQuestionRepository;

/**
 * Created by BrainMaestro
 * Date: 21/2/2016
 * Time: 8:13 PM
 */
class EloquentQuestionRepositoryTest extends TestCase
{
    protected $repository;

    protected $question;

    protected $mock;

    public function setUp()
    {
        parent::setUp();
        $this->repository = new EloquentQuestionRepository(
            new \Fce\Models\Question,
            new \Fce\Transformers\QuestionTransformer
        );
        $this->question = factory(Fce\Models\Question::class)->create();
    }

    public function testInputParameters()
    {
        $questions = factory(Fce\Models\Question::class, 5)->create();
        $questions = array_merge(
            [$this->repository->transform($this->question)['data']],
            $this->repository->transform($questions)['data']
        );

        $inputParameters = [
            'query' => "category:=" . $questions[4]['category'] . "|description:=" . $questions[4]['description'],
            'limit' => 1,
            'page' => 1
        ];

        Input::merge($inputParameters);
        $allQuestions = $this->repository->getQuestions();

        $this->assertCount(1, $allQuestions['data']);
        $this->assertEquals($questions[4], $allQuestions['data'][0]);
        $this->assertEquals($inputParameters['limit'], $allQuestions['meta']['pagination']['per_page']);
        $this->assertEquals($inputParameters['page'], $allQuestions['meta']['pagination']['current_page']);
        $this->assertEquals(1, $allQuestions['meta']['pagination']['total']);
    }

    public function testGetQuestions()
    {
        $questions = factory(Fce\Models\Question::class, 5)->create();
        $questions = array_merge(
            [$this->repository->transform($this->question)['data']],
            $this->repository->transform($questions)['data']
        );

        $allQuestions = $this->repository->getQuestions();

        $this->assertCount(count($questions), $allQuestions['data']);
        $this->assertEquals($questions, $allQuestions['data']);
    }

    public function testGetQuestionsException()
    {
        $this->setExpectedException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);

        Input::merge(['query' => 'category:=*not_a_category*']);

        $this->repository->getQuestions();
    }

    public function testGetQuestionById()
    {
        $question = $this->repository->getQuestionById($this->question->id);

        $this->assertEquals($this->repository->transform($this->question), $question);
    }

    public function testCreateQuestion()
    {
        $attributes = factory(Fce\Models\Question::class)->make()->toArray();

        $question = $this->repository->createQuestion(
            $attributes['description'],
            $attributes['category'],
            $attributes['title']
        );

        $this->assertArraySubset($attributes, $question['data']);
    }
}
