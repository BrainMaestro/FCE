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
        $this->repository = new EloquentSchoolRepository(
            new \Fce\Models\School,
            new \Fce\Transformers\SchoolTransformer
        );
        $this->school = factory(Fce\Models\School::class)->create();
    }

    public function testInputParameters()
    {
        $createdSchools = factory(Fce\Models\School::class, 2)->create();
        $createdSchools = array_merge(
            [$this->repository->transform($this->school)['data']],
            $this->repository->transform($createdSchools)['data']
        );

        $inputParameters = [
            'query' => "school:=" . $createdSchools[2]['school'] . "|description:=" . $createdSchools[2]['description'],
            'limit' => 1,
            'page' => 1
        ];

        Input::merge($inputParameters);
        $schools = $this->repository->getSchools();

        $this->assertCount(1, $schools['data']);
        $this->assertEquals($createdSchools[2], $schools['data'][0]);
        $this->assertEquals($inputParameters['limit'], $schools['meta']['pagination']['per_page']);
        $this->assertEquals($inputParameters['page'], $schools['meta']['pagination']['current_page']);
        $this->assertEquals(1, $schools['meta']['pagination']['total']);
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

    public function testGetSchoolsException()
    {
        $this->setExpectedException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);

        Input::merge(['query' => 'school:=12qwe1+']);

        $this->repository->getSchools();
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

        $school = $this->repository->createSchool($attributes['school'], $attributes['description']);

        $this->assertArraySubset($attributes, $school['data']);
    }
}
