<?php

use Fce\Repositories\Database\EloquentUserRepository;
use Illuminate\Support\Facades\Input;

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

    public function testInputParameters()
    {
        $users = factory(Fce\Models\User::class, 4)->create();
        $users = array_merge(
            [$this->repository->transform($this->user)['data']],
            $this->repository->transform($users)['data']
        );

        $inputParameters = [
            'query' => 'email:' . $users[1]['email'] . '|name:' . $users[1]['name'],
            'limit' => 1,
            'page' => 1,
        ];

        Input::merge($inputParameters);
        $allUsers = $this->repository->getUsers();

        $this->assertCount(1, $allUsers['data']);
        $this->assertEquals($users[1], $allUsers['data'][0]);
        $this->assertEquals($inputParameters['limit'], $allUsers['meta']['pagination']['per_page']);
        $this->assertEquals($inputParameters['page'], $allUsers['meta']['pagination']['current_page']);
        $this->assertEquals(1, $allUsers['meta']['pagination']['total']);
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

    public function testGetHelperUsers()
    {
        // Facsimile for helper users. :)
        $users = factory(Fce\Models\User::class, 5)->create([
            'name' => str_random(6) . ' helper',
        ]);
        $users = $this->repository->transform($users);

        $helperUsers = $this->repository->getHelperUsers();

        $this->assertArraySubset($users, $helperUsers);
    }

    public function testGetUsersException()
    {
        $this->setExpectedException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);

        Input::merge(['query' => 'email:=*not_an_email*']);

        $this->repository->getUsers();
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
        $attributes = array_except($attributes, 'active');
        $user = $this->repository->createUser($attributes['name'], $attributes['email'], 'password');

        $this->assertArraySubset($attributes, $user['data']);
    }

    public function testCreateHelperUsers()
    {
        $sections = factory(Fce\Models\Section::class, 3)->create()->toArray();

        $inserted = $this->repository->createHelperUsers($sections);

        $this->assertTrue($inserted);
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

    public function testDeleteHelperUsers()
    {
        $sections = factory(Fce\Models\Section::class, 3)->create()->toArray();

        $inserted = $this->repository->createHelperUsers($sections);
        $deleted = $this->repository->deleteHelperUsers();

        $this->assertTrue($inserted);
        $this->assertTrue($deleted);
    }

    public function testAddRole()
    {
        $role = factory(\Fce\Models\Role::class)->create();
        $role = app('\\Fce\\Transformers\\RoleTransformer')->transform($role);

        $this->repository->addRole($this->user->id, $role);

        Input::merge(['include' => 'roles']);
        $user = $this->repository->transform($this->user->fresh());

        // Check that the added roles are in the user.
        $this->assertNotEmpty($user['data']['roles']['data']);
        $this->assertEquals($role, $user['data']['roles']['data'][0]);
    }

    public function testAddPermission()
    {
        $role = factory(\Fce\Models\Role::class)->create();
        $permission = factory(\Fce\Models\Permission::class)->create();
        $permission = app('\\Fce\\Transformers\\PermissionTransformer')->transform($permission);

        $result = $this->repository->addPermission($role->id, $permission);
        $this->assertTrue($result);
    }
}
