<?php
use Fce\Repositories\Database\SQLSemesterRepository;

/**
 * Created by PhpStorm.
 * User: Cheezzy Tenorz
 * Date: 2/22/2016
 * Time: 8:12 PM
 */
class SQLSemesterRepositoryTest extends TestCase
{
    protected static $semesterRepository;

    /**
     * The basic models that are needed for all tests.
     */
    protected $semester;

    public static function setUpBeforeClass()
    {
        self::$semesterRepository = new SQLSemesterRepository;
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
            [SQLSemesterRepository::transform($this->semester)['data']],
            SQLSemesterRepository::transform($createdSemesters)['data']
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
}
