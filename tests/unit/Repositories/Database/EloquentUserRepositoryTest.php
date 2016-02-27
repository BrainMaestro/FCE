<?php

use Fce\Repositories\Database\EloquentUserRepository;

/**
 * Created by BrainMaestro
 * Date: 16/2/2016
 * Time: 10:08 PM
 */
class EloquentUserRepositoryTest extends TestCase
{
    protected static $userRepository;

    protected $school;
    protected $user;

    public static function setUpBeforeClass()
    {
        self::$userRepository = new EloquentUserRepository;
    }

    public function setUp()
    {
        parent::setUp();
        $this->school = factory(Fce\Models\School::class)->create();
        $this->user = factory(Fce\Models\User::class)->create();
    }

    public function testGetUsers()
    {
        $users = factory(Fce\Models\User::class, 4)->create();
        $users = array_merge(
            [EloquentUserRepository::transform($this->user)['data']],
            EloquentUserRepository::transform($users)['data']
        );

        $allUsers = self::$userRepository->getUsers();

        $this->assertCount(count($users), $allUsers['data']);
        $this->assertEquals($users, $allUsers['data']);
    }

    public function testGetUsersBySchool()
    {
        $school = factory(Fce\Models\School::class)->create();
        $users = factory(Fce\Models\User::class, 2)->create([
            'school_id' => $school->id
        ]);
        $users = EloquentUserRepository::transform($users)['data'];

        $otherUsers = self::$userRepository->getUsersBySchool($school->id);

        $this->assertCount(count($users), $otherUsers);
        $this->assertEquals($users, $otherUsers['data']);
        $this->assertNotEquals($users, EloquentUserRepository::transform($this->user)['data']);
    }

    public function testGetUsersBySchoolWithInvalidId()
    {
        $this->setExpectedException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);

        self::$userRepository->getUsersBySchool(parent::INVALID_ID);
    }

    public function testGetUsersById()
    {
        $user = self::$userRepository->getUserById($this->user->id);

        $this->assertEquals(EloquentUserRepository::transform($this->user), $user);
    }

    public function testGetUserByIdWithInvalidId()
    {
        $this->setExpectedException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);

        self::$userRepository->getUserById(parent::INVALID_ID);
    }

    public function testCreateUser()
    {
        $attributes = factory(Fce\Models\User::class)->make()->toArray();

        $user = self::$userRepository->createUser($attributes);

        $this->assertArraySubset($attributes, $user['data']);
    }

    public function testUpdateUser()
    {
        $attributes = factory(Fce\Models\User::class)->make()->toArray();
        $user = EloquentUserRepository::transform($this->user);

        self::$userRepository->updateUser($this->user->id, $attributes);
        $this->user = self::$userRepository->getUserById($this->user->id);

        $this->assertNotEquals($user, $this->user['data']);
        $this->assertArraySubset($attributes, $this->user['data']);
    }

    public function testDeleteUser()
    {
        $this->assertTrue(self::$userRepository->deleteUser($this->user->id));

        $this->setExpectedException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);

        self::$userRepository->getUserById($this->user->id);
    }
}
