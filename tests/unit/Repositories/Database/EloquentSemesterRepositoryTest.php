<?php
use Fce\Repositories\Database\EloquentSemesterRepository;

/**
 * Created by PhpStorm.
 * User: Cheezzy Tenorz
 * Date: 2/22/2016
 * Time: 8:12 PM
 */
class EloquentSemesterRepositoryTest extends TestCase
{
    protected static $semesterRepository;

    /**
     * The basic models that are needed for all tests.
     */
    protected $semester;

    public static function setUpBeforeClass()
    {
        self::$semesterRepository = new EloquentSemesterRepository;
    }

    public function setUp()
    {
        parent::setUp();
        $this->semester = factory(Fce\Models\Semester::class)->create();
    }

    public function testGetSemesters()
    {
        $createdSemesters = factory(Fce\Models\Semester::class, 2)->create();
        $createdSemesters = array_merge(
            [EloquentSemesterRepository::transform($this->semester)['data']],
            EloquentSemesterRepository::transform($createdSemesters)['data']
        );

        $semesters = self::$semesterRepository->getSemesters();

        $this->assertCount(count($createdSemesters), $semesters['data']);
        $this->assertEquals($createdSemesters, $semesters['data']);
    }

    public function testSetCurrentSemester()
    {
        factory(Fce\Models\Semester::class, 2)->create();
        $semester = self::$semesterRepository->setCurrentSemester($this->semester->id);

        $currentSemester = self::$semesterRepository->getCurrentSemester();

        $this->assertTrue($semester);
        $this->assertEquals($this->semester->id, $currentSemester['data']['id']);
    }

    /**
     * @depends testSetCurrentSemester
     */
    public function testGetCurrentSemester()
    {
        factory(Fce\Models\Semester::class, 2)->create();
        self::$semesterRepository->setCurrentSemester($this->semester->id);

        $this->semester = self::$semesterRepository->getCurrentSemester();

        $this->assertTrue($this->semester['data']['current_semester']);
    }

    /**
     * @depends testGetCurrentSemester
     */
    public function testGetCurrentSemesterException()
    {
        $this->setExpectedException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);

        self::$semesterRepository->getCurrentSemester();
    }

    public function testCreateSemester()
    {
        $attributes = factory(Fce\Models\Semester::class)->make()->toArray();

        $semester = self::$semesterRepository->createSemester($attributes);

        $this->assertArraySubset($attributes, $semester['data']);
    }

    public function testAddQuestionSet()
    {
        $questionSets = factory(Fce\Models\QuestionSet::class, 2)->create();
        $questionSets = \Fce\Repositories\Database\SQLQuestionSetRepository::transform($questionSets)['data'];

        // Build an array of questionSet ids
        $attributes = [];
        $type = ['midterm', 'final'];
        $status = ['Locked', 'Open', 'Done'];
        for ($i = 0; $i < count($questionSets); $i++)
        {
            $attributes[$questionSets[$i]['id']] = ['evaluation_type' => array_pop($type), 'status' => array_pop($status)];
        }

        // Check that there are no questionSets in the semester
        $this->assertEmpty($this->semester->questionSets->toArray());

        self::$semesterRepository->addQuestionSet($this->semester->id, $attributes);

        $this->semester = $this->semester->fresh();
        // Check that the added questionSets are in the semester
        $this->assertNotEmpty($this->semester->questionSets->toArray());
        $this->assertCount(count($questionSets), $this->semester->questionSets->toArray());
    }
}
