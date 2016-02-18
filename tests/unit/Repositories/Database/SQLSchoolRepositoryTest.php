<?php
use Fce\Repositories\Database\SQLSchoolRepository;

/**
 * Created by BrainMaestro.
 * Date: 2/18/16
 * Time: 3:59 PM
 */
class SQLSchoolRepositoryTest extends TestCase
{
    protected static $schoolRepository;

    /**
     * The basic models that are needed for all tests.
     */
    protected $school;

    public static function setUpBeforeClass()
    {
        self::$schoolRepository = new SQLSchoolRepository;
    }

    public function setUp()
    {
        parent::setUp();
        $this->school = factory(Fce\Models\School::class)->create();
    }

    public function testGetSchools()
    {
        $createdSchools = factory(Fce\Models\School::class, 2)->create();
        $createdSchools = array_merge(
            [SQLSchoolRepository::transform($this->school)['data']],
            SQLSchoolRepository::transform($createdSchools)['data']
        );

        $schools = self::$schoolRepository->getSchools();

        $this->assertCount(count($createdSchools), $schools['data']);
        $this->assertEquals($createdSchools, $schools['data']);
    }

    public function testGetSchoolById()
    {
        $school = self::$schoolRepository->getSchoolById($this->school->id);

        $this->assertEquals(SQLSchoolRepository::transform($this->school), $school);
    }

    public function testGetSchoolByIdWithInvalidId()
    {
        $this->setExpectedException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);

        self::$schoolRepository->getSchoolById(parent::INVALID_ID);
    }

    public function testUpdateSchool()
    {
        $attributes = factory(Fce\Models\School::class)->make()->toArray();
        $school = SQLSchoolRepository::transform($this->school);

        self::$schoolRepository->updateSchool($this->school->id, $attributes);
        $this->school = self::$schoolRepository->getSchoolById($this->school->id);

        $this->assertArraySubset($attributes, $this->school['data']);
        $this->assertNotEquals($school, $this->school);
    }

    public function testCreateSchool()
    {
        $attributes = factory(Fce\Models\School::class)->make()->toArray();

        $school = self::$schoolRepository->createSchool($attributes);

        $this->assertArraySubset($attributes, $school->toArray());
    }
}
