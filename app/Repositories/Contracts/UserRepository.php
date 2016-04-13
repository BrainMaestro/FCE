<?php

/**
 * Created by PhpStorm.
 * User: Maestro
 * Date: 9/2/2016
 * Time: 11:37 PM.
 */
namespace Fce\Repositories\Contracts;

interface UserRepository
{
    public function getUsers();

    public function getHelperUsers();

    public function getUsersBySchool($schoolId);

    public function getUserById($id);

    public function createUser($name, $email, $password);

    public function createHelperUsers(array $sections);

    public function updateUser($id, array $attributes);

    public function deleteUser($id);

    public function deleteHelperUsers();
}
