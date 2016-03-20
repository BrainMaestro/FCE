<?php

use Fce\Models\Section;
use Fce\Repositories\Database\EloquentSectionRepository;

/**
 * Created by BrainMaestro
 * Date: 14/2/2016
 * Time: 7:27 PM
 */
class EloquentSectionRepositoryTest extends TestCase
{
    protected $repository;
    protected $section;
    protected $evaluation;

    public function setUp()
    {
        parent::setUp();
        $this->repository = new EloquentSectionRepository(
            new Section,
            new \Fce\Transformers\SectionTransformer
        );
        $this->section = factory(Fce\Models\Section::class)->create();
    }

    public function testGetSectionsBySemester()
    {
        $section = $this->repository->getSectionsBySemester($this->section->semester->id);

        $this->assertEquals([$this->repository->transform($this->section)['data']], $section['data']);

        $semester = factory(Fce\Models\Semester::class)->create();
        $sections = factory(Fce\Models\Section::class, 5)->create([
            'semester_id' => $semester->id
        ]);
        $sections = $this->repository->transform($sections)['data'];
        $otherSections = $this->repository->getSectionsBySemester($semester->id);

        $this->assertCount(count($sections), $otherSections['data']);
        $this->assertEquals($sections, $otherSections['data']);
        $this->assertNotEquals($section, $otherSections);
    }

    public function testGetSectionsBySemesterWithInvalidId()
    {
        $this->setExpectedException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);

        $this->repository->getSectionsBySemester(parent::INVALID_ID);
    }

    public function testGetSectionsBySemesterAndSchool()
    {
        $semester = factory(Fce\Models\Semester::class)->create();
        $sections = factory(Fce\Models\Section::class, 5)->create([
            'semester_id' => $semester->id,
            'school_id' => $this->section->school->id
        ]);

        $sections = $this->repository->transform($sections)['data'];
        $otherSections = $this->repository->getSectionsBySemesterAndSchool(
            $semester->id,
            $this->section->school->id
        );

        $this->assertCount(count($sections), $otherSections['data']);
        $this->assertEquals($sections, $otherSections['data']);

        $school = factory(Fce\Models\School::class)->create();
        $sections = factory(Fce\Models\Section::class, 4)->create([
            'semester_id' => $this->section->semester->id,
            'school_id' => $school->id
        ]);
        $sections = $this->repository->transform($sections)['data'];
        $otherSections2 = $this->repository->getSectionsBySemesterAndSchool(
            $this->section->semester->id,
            $school->id
        );

        $this->assertCount(count($sections), $otherSections2['data']);
        $this->assertEquals($sections, $otherSections2['data']);
        $this->assertNotEquals($otherSections, $otherSections2);
    }

    public function testGetSectionsBySemesterAndSchoolWithInvalidIds()
    {
        $this->setExpectedException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);

        $this->repository->getSectionsBySemesterAndSchool(parent::INVALID_ID, parent::INVALID_ID);
    }

    public function testGetSectionById()
    {
        $section = $this->repository->getSectionById($this->section->id);

        $this->assertEquals($this->repository->transform($this->section), $section);
    }

    public function testGetSectionByInvalidId()
    {
        $this->setExpectedException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);

        $this->repository->getSectionById(parent::INVALID_ID);
    }

    public function testCreateSection()
    {
        $attributes = factory(Fce\Models\Section::class)->make()->toArray();

        $section = $this->repository->createSection($attributes);

        $this->assertArraySubset($attributes, $section['data']);
    }

    public function testUpdateSection()
    {
        $attributes = $this->repository->transform($this->section);

        $this->repository->updateSection(
            $this->section->id,
            // Random test data to updated the section with
            factory(Fce\Models\Section::class)->make()->toArray()
        );
        $section = $this->repository->getSectionById($this->section->id);

        $this->assertNotEquals($attributes, $section);
    }

    public function testSetSectionStatus()
    {
        $this->repository->setSectionStatus($this->section->id, Fce\Utility\Status::OPEN);

        $this->section = $this->repository->getSectionById($this->section->id);

        $this->assertEquals(Fce\Utility\Status::OPEN, $this->section['data']['status']);
    }

    public function testSetSectionStatusWIthIncorrectStatus()
    {
        $this->setExpectedException(\InvalidArgumentException::class);

        $this->repository->setSectionStatus($this->section->id, 'not_a_status');
    }
}
