<?php

use Fce\Repositories\Database\EloquentEvaluationRepository;

/**
 * Created by BrainMaestro
 * Date: 12/2/2016
 * Time: 11:16 PM
 */
class EloquentEvaluationRepositoryTest extends TestCase
{
    protected $repository;
    protected $evaluation;

    public function setUp()
    {
        parent::setUp();
        $this->repository = new EloquentEvaluationRepository(
            new \Fce\Models\Evaluation,
            new \Fce\Transformers\EvaluationTransformer
        );
        $this->evaluation = factory(Fce\Models\Evaluation::class)->create();
    }

    public function testGetEvaluationsBySectionAndQuestionSet()
    {
        $questionSet = factory(Fce\Models\QuestionSet::class)->create();
        $createdEvaluations = factory(Fce\Models\Evaluation::class, 5)->create([
            'question_set_id' => $questionSet->id,
            'section_id' => $this->evaluation->section->id,
        ]);

        $createdEvaluations = $this->repository->transform($createdEvaluations)['data'];

        $evaluations = $this->repository->getEvaluationsBySectionAndQuestionSet(
            $this->evaluation->section->id,
            $questionSet->id
        );

        $this->assertCount(count($createdEvaluations), $evaluations['data']);
        $this->assertEquals($createdEvaluations, $evaluations['data']);
    }

    public function testGetEvaluationBySectionAndQuestionSetWithInvalidIds()
    {
        $this->setExpectedException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);

        $this->repository->getEvaluationsBySectionAndQuestionSet(parent::INVALID_ID, parent::INVALID_ID);
    }

    public function testCreateEvaluations()
    {
        $questions = factory(Fce\Models\Question::class, 5)->create();
        $questionSet = factory(Fce\Models\QuestionSet::class)->create();
        $questionSet->questions()->attach($questions);
        $questionSet = app(\Fce\Repositories\Database\EloquentQuestionSetRepository::class)
            ->transform($questionSet)['data'];

        $section = factory(Fce\Models\Section::class)->create();

        $this->assertTrue($this->repository->createEvaluations($section->id, $questionSet));

        $evaluations = $this->repository->getEvaluationsBySectionAndQuestionSet(
            $section->id,
            $questionSet['id']
        )['data'];

        $this->assertCount($questions->count(), $evaluations);
    }

    public function testCreateEvaluationsWithInvalidIds()
    {
        $this->setExpectedException(\Illuminate\Database\QueryException::class);

        $inserted = $this->repository->createEvaluations(parent::INVALID_ID, [
            'id' => parent::INVALID_ID,
            'questions' => ['data' => [
                ['id' => parent::INVALID_ID]
            ]]
        ]);

        $this->assertFalse($inserted);
    }

    public function testIncrementEvaluation()
    {
        $this->assertEquals(1, $this->repository->incrementEvaluation($this->evaluation->id, 'one'));

        $incrementedEvaluation = $this->repository->getEvaluationsBySectionAndQuestionSet(
            $this->evaluation->section->id,
            $this->evaluation->questionSet->id
        );

        $this->assertEquals($this->evaluation->one + 1, $incrementedEvaluation['data'][0]['one']);
    }
}
