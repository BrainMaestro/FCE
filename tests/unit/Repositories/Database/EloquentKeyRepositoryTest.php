<?php

use Fce\Repositories\Database\EloquentKeyRepository;
use Illuminate\Database\QueryException;

/**
 * Created by BrainMaestro
 * Date: 19/2/2016
 * Time: 8:14 PM
 */
class EloquentKeyRepositoryTest extends TestCase
{
    protected $repository;

    protected $section;
    protected $key;

    public function setUp()
    {
        parent::setUp();
        $this->repository = new EloquentKeyRepository(
            new \Fce\Models\Key,
            new \Fce\Transformers\KeyTransformer
        );
        $this->key = factory(Fce\Models\Key::class)->create();
    }

    public function testGetKeysBySection()
    {
        $key = $this->repository->getKeysBySection($this->key->section->id);

        $this->assertCount(1, $key['data']);

        $this->assertEquals([$this->repository->transform($this->key)['data']], $key['data']);

        $section = factory(Fce\Models\Section::class)->create();
        $keys = factory(Fce\Models\Key::class, 5)->create(['section_id' => $section->id]);
        $keys = $this->repository->transform($keys)['data'];

        $allKeys = $this->repository->getKeysBySection($section->id);

        $this->assertCount(count($keys), $allKeys['data']);
        $this->assertEquals($keys, $allKeys['data']);
    }

    public function testGetKeyByValue()
    {
        $key = $this->repository->getKeyByValue($this->key->value);

        $this->assertEquals($this->repository->transform($this->key), $key);
    }

    public function testCreateKeys()
    {
        $keys = $this->repository->createKeys($this->key->section->toArray());

        $this->assertCount((int) $this->key->section->enrolled, $keys);
    }

    public function testCreateKeysException()
    {
        $repository = $this->getMockBuilder(EloquentKeyRepository::class)
            ->setMethods(['create'])
            ->disableOriginalConstructor()
            ->getMock();
        $repository->expects($this->exactly(EloquentKeyRepository::MAX_TRIES + 1))
            ->method('create')
            ->will($this->throwException(
                new QueryException('', [], new \Exception)
            ));

        $this->setExpectedException(QueryException::class);

        $repository->createKeys($this->key->section->toArray());
    }

    public function testSetGivenOut()
    {
        $this->assertNotTrue($this->key->given_out);

        $this->assertTrue($this->repository->setGivenOut($this->key->value));

        $key = $this->repository->transform($this->key->fresh());

        $this->assertTrue($key['data']['given_out']);
    }

    public function testSetUsed()
    {
        $this->assertNotTrue($this->key->used);

        $this->assertTrue($this->repository->setUsed($this->key->value));

        $key = $this->repository->transform($this->key->fresh());

        $this->assertTrue($key['data']['used']);
    }

    public function testDeleteKeys()
    {
        $this->assertTrue($this->repository->deleteKeys($this->key->section->id));

        $this->setExpectedException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);

        $this->repository->getKeysBySection($this->key->section->toArray()['id']);
    }
}
