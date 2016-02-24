<?php

use Fce\Repositories\Database\SQLQuestionSetRepository;
/**
 * Created by BrainMaestro
 * Date: 22/2/2016
 * Time: 12:11 PM
 */
class SQLQuestionSetRepositoryTest extends TestCase
{
    protected static $questionSetRepository;

    protected $questionSet;

    public static function setUpBeforeClass()
    {
        self::$questionSetRepository = new SQLQuestionSetRepository;
    }

    public function setUp()
    {
        parent::setUp();
        $this->questionSet = factory(Fce\Models\QuestionSet::class)->create();
    }

    public function testGetQuestionSets()
    {
        $questionSets = factory(Fce\Models\QuestionSet::class, 3)->create();
        $questionSets = array_merge(
            [SQLQuestionSetRepository::transform($this->questionSet)['data']],
            SQLQuestionSetRepository::transform($questionSets)['data']
        );

        $allQuestionSets = self::$questionSetRepository->getQuestionSets();

        $this->assertCount(count($questionSets), $allQuestionSets['data']);
        $this->assertEquals($questionSets, $allQuestionSets['data']);
    }

    public function testGetQuestionSetById()
    {
        $questionSet = self::$questionSetRepository->getQuestionSetById($this->questionSet->id);

        $this->assertEquals(SQLQuestionSetRepository::transform($this->questionSet), $questionSet);
    }

    public function testCreateQuestionSet()
    {
        $attributes = factory(Fce\Models\QuestionSet::class)->make()->toArray();

        $questionSet = self::$questionSetRepository->createQuestionSet($attributes);

        $this->assertArraySubset($attributes, $questionSet['data']);
    }

    public function testAddQuestion()
    {
        $questions = factory(Fce\Models\Question::class, 2)->create();
        $questions = \Fce\Repositories\Database\SQLQuestionRepository::transform($questions)['data'];
        // Build an array of question ids
        $questionIds = array_map(function($question) {
            return $question['id'];
        }, $questions);

        $questionSet = SQLQuestionSetRepository::transform($this->questionSet);

        // Check that there are no questions in the question set
        $this->assertEmpty($questionSet['data']['questions']['data']);

        self::$questionSetRepository->addQuestions($this->questionSet->id, $questionIds);

        $questionSet = SQLQuestionSetRepository::transform($this->questionSet->fresh());

        // Check that the added questions are in the question set
        $this->assertNotEmpty($questionSet['data']['questions']['data']);
        $this->assertEquals($questions, $questionSet['data']['questions']['data']);
    }
}
