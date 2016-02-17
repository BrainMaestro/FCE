<?php

class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    const INVALID_ID = -1;
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

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
