<?php

use Fce\Repositories\Database\SQLEvaluationRepository;

/**
 * Created by BrainMaestro
 * Date: 12/2/2016
 * Time: 11:16 PM
 */
class SQLEvaluationRepositoryTest extends TestCase
{
    protected static $evaluationRepository;

    /**
     * The basic models that are needed for all tests
     */
    protected $questionSet;
    protected $question;
    protected $semester;
    protected $school;
    protected $section;
    protected $evaluation;

    public static function setUpBeforeClass()
    {
        self::$evaluationRepository = new SQLEvaluationRepository;
    }

    public function setUp()
    {
        parent::setUp();
        $this->questionSet = factory(Fce\Models\QuestionSet::class)->create();
        $this->question = factory(Fce\Models\Question::class)->create();
        $this->semester = factory(Fce\Models\Semester::class)->create();
        $this->school = factory(Fce\Models\School::class)->create();
        $this->section = factory(Fce\Models\Section::class)->create();
        $this->evaluation = factory(Fce\Models\Evaluation::class)->create();
    }

    public function testGetEvaluationsBySectionAndQuestionSet()
    {
        $questionSet = factory(Fce\Models\QuestionSet::class)->create();
        $createdEvaluations = factory(Fce\Models\Evaluation::class, 5)->create([
            'question_set_id' => $questionSet->id
        ]);

        $evaluations = self::$evaluationRepository->getEvaluationsBySectionAndQuestionSet(
            $this->section->id,
            $questionSet->id
        );

        $this->assertCount($createdEvaluations->count(), $evaluations['data']);
        $this->assertEquals(SQLEvaluationRepository::transform($createdEvaluations)['data'], $evaluations['data']);
    }

    public function testGetEvaluationBySectionAndQuestionSetWithInvalidIds()
    {
        $this->setExpectedException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);

        self::$evaluationRepository->getEvaluationsBySectionAndQuestionSet(-1, -1);
    }

    public function testGetEvaluationsBySectionQuestionSetAndQuestion()
    {
        $evaluation = self::$evaluationRepository->getEvaluationBySectionQuestionSetAndQuestion(
            $this->section->id,
            $this->questionSet->id,
            $this->question->id
        );

        $this->assertCount(1, $evaluation);
        $this->assertEquals(SQLEvaluationRepository::transform($this->evaluation), $evaluation);

        $question = factory(Fce\Models\Question::class)->create();
        $this->evaluation = factory(Fce\Models\Evaluation::class)->create([
            'question_id' => $question->id
        ]);

        $otherEvaluation = self::$evaluationRepository->getEvaluationBySectionQuestionSetAndQuestion(
            $this->section->id,
            $this->questionSet->id,
            $question->id
        );

        $this->assertCount(1, $otherEvaluation);
        $this->assertEquals(SQLEvaluationRepository::transform($this->evaluation), $otherEvaluation);
        $this->assertNotEquals($evaluation, $otherEvaluation);

    }

    public function testGetEvaluationBySectionQuestionSetAndQuestionWithInvalidIds()
    {
        $this->setExpectedException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);

        self::$evaluationRepository->getEvaluationBySectionQuestionSetAndQuestion(-1, -1, -1);
    }

    public function testCreateEvaluation()
    {
        // Get random attributes without persisting
        $attributes = factory(Fce\Models\Evaluation::class)->make()->toArray();

        $evaluation = self::$evaluationRepository->createEvaluation($attributes);

        $this->assertArraySubset($attributes, $evaluation->toArray());
    }

    public function testCreateEvaluationWithIncorrectAttributes()
    {
        $this->setExpectedException(\InvalidArgumentException::class);

        self::$evaluationRepository->createEvaluation(['not_an_attribute' => true]);
    }

    public function testIncrementEvaluation()
    {
        self::$evaluationRepository->incrementEvaluation($this->evaluation->id, 'one');

        $incrementedEvaluation = self::$evaluationRepository->getEvaluationBySectionQuestionSetAndQuestion(
            $this->evaluation->section->id,
            $this->evaluation->questionSet->id,
            $this->evaluation->question->id
        );

        $this->assertEquals($this->evaluation->one + 1, $incrementedEvaluation['data']['one']);
    }
}


