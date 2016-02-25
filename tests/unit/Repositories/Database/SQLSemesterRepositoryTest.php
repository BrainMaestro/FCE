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
    protected $repository;
    protected $semester;

    public function setUp()
    {
        parent::setUp();
        $this->repository = new SQLSemesterRepository(
            new \Fce\Models\Semester,
            new \Fce\Transformers\SemesterTransformer
        );
        $this->semester = factory(Fce\Models\Semester::class)->create();
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

        $semester = $this->repository->createSemester($attributes);

        $this->assertArraySubset($attributes, $semester['data']);
    }
}
