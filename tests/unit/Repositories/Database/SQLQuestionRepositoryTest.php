<?php
use Fce\Repositories\Database\SQLQuestionRepository;

/**
 * Created by BrainMaestro
 * Date: 21/2/2016
 * Time: 8:13 PM
 */
class SQLQuestionRepositoryTest extends TestCase
{
    protected static $questionRepository;

    protected $question;

    public static function setUpBeforeClass()
    {
        self::$questionRepository = new SQLQuestionRepository;
    }

    public function setUp()
    {
        parent::setUp();
        $this->question = factory(Fce\Models\Question::class)->create();
    }

    public function testGetQuestions()
    {
        $questions = factory(Fce\Models\Question::class, 5)->create();
        $questions = array_merge(
            [SQLQuestionRepository::transform($this->question)['data']],
            SQLQuestionRepository::transform($questions)['data']
        );

        $allQuestions = self::$questionRepository->getQuestions();

        $this->assertCount(count($questions), $allQuestions['data']);
        $this->assertEquals($questions, $allQuestions['data']);
    }

    public function testGetQuestionById()
    {
        $question = self::$questionRepository->getQuestionById($this->question->id);

        $this->assertEquals(SQLQuestionRepository::transform($this->question), $question);
    }

    public function testCreateQuestion()
    {
        $attributes = factory(Fce\Models\Question::class)->make()->toArray();

        $question = self::$questionRepository->createQuestion($attributes);

        $this->assertArraySubset($attributes, $question['data']);
    }
}
