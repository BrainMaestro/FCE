<?php
/**
 * Created by PhpStorm.
 * User: Cheezzy Tenorz
 * Date: 10/29/2015
 * Time: 7:47 PM
 */

namespace Fce\Repositories;

interface IUsersRepository
{
    public function getUsers($data);

    public function getUserById($user_id);

    public function getUserBySectionId($section_id);

    public function createUser($data);

    public function deleteUserById($user_id);

    public function updateUser($data);
}
