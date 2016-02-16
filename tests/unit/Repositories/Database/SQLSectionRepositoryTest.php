<?php

use Fce\Models\Section;
use Fce\Repositories\Database\SQLSectionRepository;

/**
 * Created by BrainMaestro
 * Date: 14/2/2016
 * Time: 7:27 PM
 */
class SQLSectionRepositoryTest extends TestCase
{
    protected static $sectionRepository;

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
        self::$sectionRepository = new SQLSectionRepository;
    }

    public function setUp()
    {
        parent::setUp();
        $this->questionSet = factory(Fce\Models\QuestionSet::class)->create();
        $this->question = factory(Fce\Models\Question::class)->create();
        $this->semester = factory(Fce\Models\Semester::class)->create();
        $this->school = factory(Fce\Models\School::class)->create();
        $this->section = factory(Fce\Models\Section::class)->create();
    }

    public function testGetSectionsBySemester()
    {
        $section = self::$sectionRepository->getSectionsBySemester($this->semester->id);

        $this->assertEquals(SQLSectionRepository::transform($this->section)['data'], $section['data'][0]);

        $semester = factory(Fce\Models\Semester::class)->create();
        $sections = factory(Fce\Models\Section::class, 5)->create([
            'semester_id' => $semester->id
        ]);
        $otherSections = self::$sectionRepository->getSectionsBySemester($semester->id);

        $this->assertCount(5, $otherSections['data']);
        $this->assertEquals(SQLSectionRepository::transform($sections)['data'], $otherSections['data']);
        $this->assertNotEquals($section, $otherSections);
    }

    public function testGetSectionsBySemesterWithInvalidId()
    {
        $this->setExpectedException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);

        self::$sectionRepository->getSectionsBySemester(-1);
    }

    public function testGetSectionsBySemesterAndSchool()
    {
        $semester = factory(Fce\Models\Semester::class)->create();
        $sections = factory(Fce\Models\Section::class, 5)->create([
            'semester_id' => $semester->id
        ]);
        $otherSections = self::$sectionRepository->getSectionsBySemesterAndSchool(
            $semester->id,
            $this->school->id
        );

        $this->assertCount(5, $otherSections['data']);
        $this->assertEquals(SQLSectionRepository::transform($sections)['data'], $otherSections['data']);

        $school = factory(Fce\Models\School::class)->create();
        $sections = factory(Fce\Models\Section::class, 5)->create([
            'school_id' => $school->id
        ]);
        $otherSections2 = self::$sectionRepository->getSectionsBySemesterAndSchool(
            $this->semester->id,
            $school->id
        );

        $this->assertCount(5, $otherSections2['data']);
        $this->assertEquals(SQLSectionRepository::transform($sections)['data'], $otherSections2['data']);
        $this->assertNotEquals($otherSections, $otherSections2);
    }

    public function testGetSectionsBySemesterAndSchoolWithInvalidIds()
    {
        $this->setExpectedException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);

        self::$sectionRepository->getSectionsBySemesterAndSchool(-1, -1);
    }

    public function testGetSectionById()
    {
        $section = self::$sectionRepository->getSectionById($this->section->id);

        $this->assertEquals(SQLSectionRepository::transform($this->section), $section);
    }

    public function testGetSectionByInvalidId()
    {
        $this->setExpectedException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);

        self::$sectionRepository->getSectionById(-1);
    }

    public function testCreateSection()
    {
        $attributes = factory(Fce\Models\Section::class)->make()->toArray();

        $section = self::$sectionRepository->createSection($attributes);

        $this->assertArraySubset($attributes, $section->toArray());
    }

    public function testUpdateSection()
    {
        $attributes = SQLSectionRepository::transform($this->section);

        self::$sectionRepository->updateSection(
            $this->section->id,
            // Random test data to updated the section with
            factory(Fce\Models\Section::class)->make()->toArray()
        );
        $section = self::$sectionRepository->getSectionById($this->section->id);

        $this->assertNotEquals($attributes, $section);
    }

    public function testSetSectionStatus()
    {
        self::$sectionRepository->setSectionStatus($this->section->id, Section::STATUS_OPEN);

        $this->section = self::$sectionRepository->getSectionById($this->section->id);

        $this->assertEquals(Section::STATUS_OPEN, $this->section['data']['status']);
    }

    public function testGetSectionStatusWIthIncorrectStatus()
    {
        $this->setExpectedException(\InvalidArgumentException::class);

        self::$sectionRepository->setSectionStatus($this->section->id, 'not_a_status');
    }
}
