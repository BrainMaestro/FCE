<?php
use Fce\Repositories\Database\EloquentSchoolRepository;

/**
 * Created by BrainMaestro.
 * Date: 2/18/16
 * Time: 3:59 PM
 */
class EloquentSchoolRepositoryTest extends TestCase
{
    protected $repository;

    protected $school;

    public function setUp()
    {
        parent::setUp();
        $this->repository = new SQLSchoolRepository(
            new \Fce\Models\School,
            new \Fce\Transformers\SchoolTransformer
        );
        $this->school = factory(Fce\Models\School::class)->create();
    }

    public function testGetSchools()
    {
        $createdSchools = factory(Fce\Models\School::class, 2)->create();
        $createdSchools = array_merge(
            [$this->repository->transform($this->school)['data']],
            $this->repository->transform($createdSchools)['data']
        );

        $schools = $this->repository->getSchools();

        $this->assertCount(count($createdSchools), $schools['data']);
        $this->assertEquals($createdSchools, $schools['data']);
    }

    public function testGetSchoolById()
    {
        $school = $this->repository->getSchoolById($this->school->id);

        $this->assertEquals($this->repository->transform($this->school), $school);
    }

    public function testGetSchoolByIdWithInvalidId()
    {
        $this->setExpectedException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);

        $this->repository->getSchoolById(parent::INVALID_ID);
    }

    public function testUpdateSchool()
    {
        $attributes = factory(Fce\Models\School::class)->make()->toArray();
        $school = $this->repository->transform($this->school);

        $this->repository->updateSchool($this->school->id, $attributes);
        $this->school = $this->repository->getSchoolById($this->school->id);

        $this->assertArraySubset($attributes, $this->school['data']);
        $this->assertNotEquals($school, $this->school);
    }

    public function testCreateSchool()
    {
        $attributes = factory(Fce\Models\School::class)->make()->toArray();

        $school = $this->repository->createSchool($attributes);

        $this->assertArraySubset($attributes, $school['data']);
    }
}
