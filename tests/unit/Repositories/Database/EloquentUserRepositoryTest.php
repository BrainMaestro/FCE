<?php

use Fce\Repositories\Database\EloquentUserRepository;

/**
 * Created by BrainMaestro
 * Date: 16/2/2016
 * Time: 10:08 PM.
 */
class EloquentUserRepositoryTest extends TestCase
{
    protected $repository;
    protected $user;


    public function setUp()
    {
        parent::setUp();
        $this->repository = new EloquentUserRepository(
            new \Fce\Models\User,
            new \Fce\Transformers\UserTransformer
        );
        $this->user = factory(Fce\Models\User::class)->create();
    }

    public function testGetUsers()
    {
        $users = factory(Fce\Models\User::class, 4)->create();
        $users = array_merge(
            [$this->repository->transform($this->user)['data']],
            $this->repository->transform($users)['data']
        );

        $allUsers = $this->repository->getUsers();

        $this->assertCount(count($users), $allUsers['data']);
        $this->assertEquals($users, $allUsers['data']);
    }

    public function testGetUsersBySchool()
    {
        $school = factory(Fce\Models\School::class)->create();
        $users = factory(Fce\Models\User::class, 2)->create()->each(function ($user) use ($school) {
             $user->schools()->save($school);
        });
        
        $users = $this->repository->transform($users)['data'];

        $otherUsers = $this->repository->getUsersBySchool($school->id);

        $this->assertCount(count($users), $otherUsers['data']);
        $this->assertEquals($users, $otherUsers['data']);
        $this->assertNotEquals($users, $this->repository->transform($this->user)['data']);
    }

    public function testGetUsersBySchoolWithInvalidId()
    {
        $this->setExpectedException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);

        $this->repository->getUsersBySchool(parent::INVALID_ID);
    }

    public function testGetUsersById()
    {
        $user = $this->repository->getUserById($this->user->id);

        $this->assertEquals($this->repository->transform($this->user), $user);
    }

    public function testGetUserByIdWithInvalidId()
    {
        $this->setExpectedException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);

        $this->repository->getUserById(parent::INVALID_ID);
    }

    public function testCreateUser()
    {
        $attributes = factory(Fce\Models\User::class)->make()->toArray();

        $user = $this->repository->createUser(array_merge($attributes, ['password' => bcrypt('password')]));

        $this->assertArraySubset($attributes, $user['data']);
    }

    public function testUpdateUser()
    {
        $attributes = factory(Fce\Models\User::class)->make()->toArray();
        $user = $this->repository->transform($this->user);

        $this->repository->updateUser($this->user->id, $attributes);
        $this->user = $this->repository->getUserById($this->user->id);

        $this->assertNotEquals($user, $this->user['data']);
        $this->assertArraySubset($attributes, $this->user['data']);
    }

    public function testDeleteUser()
    {
        $this->assertTrue($this->repository->deleteUser($this->user->id));

        $this->setExpectedException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);

        $this->repository->getUserById($this->user->id);
    }

    public function testDisableUser()
    {
        $this->assertTrue($this->repository->disableUser($this->user->id));

        $user = $this->repository->transform($this->user->fresh());

        $this->assertFalse($user['data']['active']);
    }

    public function testEnableUser()
    {
        $this->assertTrue($this->repository->enableUser($this->user->id));

        $user = $this->repository->transform($this->user->fresh());

        $this->assertTrue($user['data']['active']);
    }
}
