<?php
/**
 * Created by PhpStorm.
 * User: Cheezzy Tenorz
 * Date: 10/29/2015
 * Time: 8:30 PM
 */

namespace Fce\Repositories;

interface ISchoolsRepository
{
    public function getSchools($data);

    public function getSchoolById($school_id);

    public function createSchool($data);

    public function updateSchoolById($school_id);
}
