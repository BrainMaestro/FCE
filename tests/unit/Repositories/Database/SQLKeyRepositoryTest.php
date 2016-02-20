<?php

use Fce\Repositories\Database\SQLKeyRepository;

/**
 * Created by BrainMaestro
 * Date: 19/2/2016
 * Time: 8:14 PM
 */
class SQLKeyRepositoryTest extends TestCase
{
    protected static $keyRepository;

    protected $section;
    protected $key;

    public static function setUpBeforeClass()
    {
        self::$keyRepository = new SQLKeyRepository;
    }

    public function setUp()
    {
        parent::setUp();
        factory(Fce\Models\Semester::class)->create();
        factory(Fce\Models\School::class)->create();
        $this->section = factory(Fce\Models\Section::class)->create();
        $this->key = factory(Fce\Models\Key::class)->create();
    }

    public function testGetKeysBySection()
    {
        $key = self::$keyRepository->getKeysBySection($this->section->id);

        $this->assertCount(1, $key['data']);
        $this->assertEquals([SQLKeyRepository::transform($this->key)['data']], $key['data']);

        $section = factory(Fce\Models\Section::class)->create();
        $keys = factory(Fce\Models\Key::class, 5)->create(['section_id' => $section->id]);
        $keys = SQLKeyRepository::transform($keys)['data'];

        $allKeys = self::$keyRepository->getKeysBySection($section->id);

        $this->assertCount(count($keys), $allKeys['data']);
        $this->assertEquals($keys, $allKeys['data']);
    }

    public function testCreateKeys()
    {
        $keys = self::$keyRepository->createKeys($this->section->toArray());

        $this->assertCount($this->section->enrolled, $keys);
    }

    public function testSetGivenOut()
    {
        $this->assertTrue(self::$keyRepository->setGivenOut($this->key->id));

        $key = SQLKeyRepository::transform($this->key->fresh());

        $this->assertTrue($key['data']['given_out']);
    }

    public function testSetUsed()
    {
        $this->assertTrue(self::$keyRepository->setUsed($this->key->id));

        $key = SQLKeyRepository::transform($this->key->fresh());

        $this->assertTrue($key['data']['used']);
    }

    public function testDeletekeys()
    {
        $this->assertTrue(self::$keyRepository->deleteKeys($this->section->id));

        $this->setExpectedException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);

        self::$keyRepository->getKeysBySection($this->section->toArray()['id']);
    }
}
