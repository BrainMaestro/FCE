<?php

use Fce\Repositories\Database\EloquentQuestionSetRepository;
use Fce\Repositories\Database\EloquentSemesterRepository;

/**
 * Created by PhpStorm.
 * User: Cheezzy Tenorz
 * Date: 2/22/2016
 * Time: 8:12 PM.
 */
class EloquentSemesterRepositoryTest extends TestCase
{
    protected $repository;
    protected $semester;
    protected $questionSetRepository;

    public function setUp()
    {
        parent::setUp();
        $this->repository = new EloquentSemesterRepository(
            new \Fce\Models\Semester,
            new \Fce\Transformers\SemesterTransformer
        );

        $this->questionSetRepository = new EloquentQuestionSetRepository(
            new \Fce\Models\QuestionSet(),
            new \Fce\Transformers\QuestionSetTransformer()
        );

        $this->semester = factory(Fce\Models\Semester::class)->create();
    }

    public function testInputParameters()
    {
        $semestersYear = factory(Fce\Models\Semester::class, 5)->create([
            'year' => 2016,
        ]);
        $semestersYear = $this->repository->transform($semestersYear)['data'];

        Input::merge([
            'query' => 'year:' . $semestersYear[0]['year'],
        ]);
        $semesters = $this->repository->getSemesters();

        $this->assertCount(count($semestersYear), $semesters['data']);
        $this->assertEquals($semestersYear, $semesters['data']);
        $this->assertEquals(count($semestersYear), $semesters['meta']['pagination']['total']);

        $semestersSeason = factory(Fce\Models\Semester::class, 5)->create([
            'season' => 'Spring',
        ]);
        $semestersSeason = $this->repository->transform($semestersSeason)['data'];

        Input::merge([
            'query' => 'season:' . $semestersSeason[0]['season'],
        ]);
        $semesters = $this->repository->getSemesters();

        $this->assertCount(count($semestersSeason), $semesters['data']);
        $this->assertEquals($semestersSeason, $semesters['data']);
        $this->assertEquals(count($semestersSeason), $semesters['meta']['pagination']['total']);

        $this->assertNotEquals($semestersYear, $semestersSeason);
    }

    public function testGetSemesters()
    {
        $createdSemesters = factory(Fce\Models\Semester::class, 2)->create();
        $createdSemesters = array_merge(
            [$this->repository->transform($this->semester)['data']],
            $this->repository->transform($createdSemesters)['data']
        );

        $semesters = $this->repository->getSemesters();

        $this->assertCount(count($createdSemesters), $semesters['data']);
        $this->assertEquals($createdSemesters, $semesters['data']);
    }

    public function testGetSemestersException()
    {
        $this->setExpectedException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);

        Input::merge(['query' => 'season:=*not_a_season*']);

        $this->repository->getSemesters();
    }

    public function testGetSemesterById()
    {
        $semester = $this->repository->getSemesterById($this->semester->id);

        $this->assertEquals($this->repository->transform($this->semester), $semester);
    }

    public function testGetSemesterByIdWithInvalidId()
    {
        $this->setExpectedException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);

        $this->repository->getSemesterById(parent::INVALID_ID);
    }

    public function testSetCurrentSemester()
    {
        factory(Fce\Models\Semester::class, 2)->create();
        $semester = $this->repository->setCurrentSemester($this->semester->id);

        $currentSemester = $this->repository->getCurrentSemester();

        $this->assertTrue($semester);
        $this->assertEquals($this->semester->id, $currentSemester['data']['id']);
    }

    /**
     * @depends testSetCurrentSemester
     */
    public function testGetCurrentSemester()
    {
        factory(Fce\Models\Semester::class, 2)->create();
        $this->repository->setCurrentSemester($this->semester->id);

        $this->semester = $this->repository->getCurrentSemester();

        $this->assertTrue($this->semester['data']['current_semester']);
    }

    /**
     * @depends testGetCurrentSemester
     */
    public function testGetCurrentSemesterException()
    {
        $this->setExpectedException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);

        $this->repository->getCurrentSemester();
    }

    public function testCreateSemester()
    {
        $attributes = factory(Fce\Models\Semester::class)->make()->toArray();

        $semester = $this->repository->createSemester($attributes['season'], $attributes['year']);

        $this->assertArraySubset($attributes, $semester['data']);
    }

    public function testAddQuestionSet()
    {
        $types = ['midterm', 'final', 'other'];
        $questionSets = factory(Fce\Models\QuestionSet::class, 3)->create();
        $questionSets = $this->questionSetRepository->transform($questionSets)['data'];

        // Check that there are no questionSets in the semester
        $this->assertEmpty($this->semester->questionSets->toArray());

        foreach ($questionSets as $questionSet) {
            $this->repository->addQuestionSet(
                $this->semester->id,
                $questionSet['id'],
                array_shift($types)
            );
        }

        $semesterQuestionSets = $this->questionSetRepository->transform(
            $this->semester->fresh()->questionSets
        )['data'];

        // Check that the added questionSets are in the semester
        $this->assertNotEmpty($semesterQuestionSets);
        $this->assertCount(count($questionSets), $semesterQuestionSets);
        $this->assertArraySubset($questionSets, $semesterQuestionSets);
    }

    /**
     * @depends testAddQuestionSet
     */
    public function testSetQuestionSetStatus()
    {
        $questionSet = factory(Fce\Models\QuestionSet::class)->create();
        $questionSet = $this->questionSetRepository->transform($questionSet)['data'];

        $this->repository->addQuestionSet(
            $this->semester->id,
            $questionSet['id'],
            'midterm'
        );
        $this->repository->setQuestionSetStatus(
            $this->semester->id,
            $questionSet['id'],
            Fce\Utility\Status::OPEN
        );

        $semesterQuestionSet = $this->repository->transform($this->semester->fresh())['data'];

        $this->assertEquals(Fce\Utility\Status::OPEN, $semesterQuestionSet['questionSets']['data'][0]['status']);
    }

    /**
     * @depends testSetQuestionSetStatus
     */
    public function testGetOpenQuestionSet()
    {
        $questionSet = factory(\Fce\Models\QuestionSet::class)->create();
        $questionSet = $this->questionSetRepository->transform($questionSet)['data'];

        $this->repository->addQuestionSet(
            $this->semester->id,
            $questionSet['id'],
            'midterm'
        );
        $this->repository->addQuestionSet(
            $this->semester->id,
            factory(\Fce\Models\QuestionSet::class)->create()->id,
            'final'
        );
        $this->repository->setQuestionSetStatus(
            $this->semester->id,
            $questionSet['id'],
            Fce\Utility\Status::OPEN
        );

        $openQuestionSet = $this->repository->getOpenQuestionSet($this->semester->id);

        $this->assertEquals($questionSet['id'], $openQuestionSet['id']);
        $this->assertEquals(Fce\Utility\Status::OPEN, $openQuestionSet['status']);
    }
}
