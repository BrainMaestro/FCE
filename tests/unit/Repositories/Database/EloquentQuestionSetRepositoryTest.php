<?php

use Fce\Repositories\Database\EloquentQuestionSetRepository;

/**
 * Created by BrainMaestro
 * Date: 22/2/2016
 * Time: 12:11 PM.
 */
class EloquentQuestionSetRepositoryTest extends TestCase
{
    protected $repository;

    protected $questionSet;

    public function setUp()
    {
        parent::setUp();
        $this->repository = new EloquentQuestionSetRepository(
            new \Fce\Models\QuestionSet,
            new \Fce\Transformers\QuestionSetTransformer
        );
        $this->questionSet = factory(Fce\Models\QuestionSet::class)->create();
    }

    public function testInputParameters()
    {
        $questionSets = factory(Fce\Models\QuestionSet::class, 3)->create();
        $questionSets = array_merge(
            [$this->repository->transform($this->questionSet)['data']],
            $this->repository->transform($questionSets)['data']
        );

        $inputParameters = [
            'query' => 'name:' . $questionSets[1]['name'],
            'limit' => 1,
            'page' => 1,
        ];

        Input::merge($inputParameters);
        $allQuestionSets = $this->repository->getQuestionSets();

        $this->assertCount(1, $allQuestionSets['data']);
        $this->assertEquals($questionSets[1], $allQuestionSets['data'][0]);
        $this->assertEquals($inputParameters['limit'], $allQuestionSets['meta']['pagination']['per_page']);
        $this->assertEquals($inputParameters['page'], $allQuestionSets['meta']['pagination']['current_page']);
        $this->assertEquals(1, $allQuestionSets['meta']['pagination']['total']);
    }

    public function testGetQuestionSets()
    {
        $questionSets = factory(Fce\Models\QuestionSet::class, 3)->create();
        $questionSets = array_merge(
            [$this->repository->transform($this->questionSet)['data']],
            $this->repository->transform($questionSets)['data']
        );

        $allQuestionSets = $this->repository->getQuestionSets();

        $this->assertCount(count($questionSets), $allQuestionSets['data']);
        $this->assertEquals($questionSets, $allQuestionSets['data']);
    }

    public function testGetQuestionSetsException()
    {
        $this->setExpectedException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);

        Input::merge(['query' => 'name:=*not_a_name*']);

        $this->repository->getQuestionSets();
    }

    public function testGetQuestionSetById()
    {
        $questionSet = $this->repository->getQuestionSetById($this->questionSet->id);

        $this->assertEquals($this->repository->transform($this->questionSet), $questionSet);
    }

    public function testCreateQuestionSet()
    {
        $attributes = factory(Fce\Models\QuestionSet::class)->make()->toArray();

        $questionSet = $this->repository->createQuestionSet($attributes['name']);

        $this->assertArraySubset($attributes, $questionSet['data']);
    }

    public function testAddQuestion()
    {
        $questions = factory(Fce\Models\Question::class, 2)->create();
        $questionRepository = new \Fce\Repositories\Database\EloquentQuestionRepository(
            new \Fce\Models\Question,
            new \Fce\Transformers\QuestionTransformer
        );
        $questions = $questionRepository->transform($questions)['data'];

        // Build an array of question ids and their position
        for ($i = 0, $questionIds = []; $i < count($questions);) {
            $questionIds[$questions[$i]['id']] = ['position' => ++$i];
        }

        $questionSet = $this->repository->transform($this->questionSet);

        // Check that there are no questions in the question set
        $this->assertEmpty($questionSet['data']['questions']['data']);

        $this->repository->addQuestions($this->questionSet->id, $questionIds);

        $questionSet = $this->repository->transform($this->questionSet->fresh());

        // Check that the added questions are in the question set
        $this->assertNotEmpty($questionSet['data']['questions']['data']);
        $this->assertEquals($questions, $questionSet['data']['questions']['data']);
    }
}
