<?php

class TestCase extends Illuminate\Foundation\Testing\TestCase
{

    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * The basic models that are needed for all tests
     */
    protected $questionSet;
    protected $questions;
    protected $semester;
    protected $school;
    protected $section;

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }

    /**
     * Prepare for test
     */
    public function setUp()
    {
        parent::setUp();
        DB::beginTransaction();
        $this->questionSet = factory(Fce\Models\QuestionSet::class)->create();
        $this->questions = factory(Fce\Models\Question::class, 10)->create();
        $this->semester = factory(Fce\Models\Semester::class)->create();
        $this->school = factory(Fce\Models\School::class)->create();
        $this->section = factory(Fce\Models\Section::class)->create();
    }

    /**
     * Revert DB changes after test
     */
    public function tearDown()
    {
        DB::rollBack();
        parent::tearDown();
    }
}
