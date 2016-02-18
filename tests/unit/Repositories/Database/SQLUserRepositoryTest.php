<?php

use Fce\Repositories\Database\SQLUserRepository;

/**
 * Created by BrainMaestro
 * Date: 16/2/2016
 * Time: 10:08 PM
 */
class SQLUserRepositoryTest extends TestCase
{
    protected static $userRepository;

    protected $school;
    protected $user;

    public static function setUpBeforeClass()
    {
        self::$userRepository = new SQLUserRepository;
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
            [SQLUserRepository::transform($this->user)['data']],
            SQLUserRepository::transform($users)['data']
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
        $users = SQLUserRepository::transform($users)['data'];

        $otherUsers = self::$userRepository->getUsersBySchool($school->id);

        $this->assertCount(count($users), $otherUsers);
        $this->assertEquals($users, $otherUsers['data']);
        $this->assertNotEquals($users, SQLUserRepository::transform($this->user)['data']);
    }

    public function testGetUsersBySchoolWithInvalidId()
    {
        $this->setExpectedException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);

        self::$userRepository->getUsersBySchool(parent::INVALID_ID);
    }

    public function testGetUsersById()
    {
        $user = self::$userRepository->getUserById($this->user->id);

        $this->assertEquals(SQLUserRepository::transform($this->user), $user);
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

        $this->assertArraySubset($attributes, $user->toArray());
    }

    public function testUpdateUser()
    {
        $attributes = factory(Fce\Models\User::class)->make()->toArray();
        $user = SQLUserRepository::transform($this->user);

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
