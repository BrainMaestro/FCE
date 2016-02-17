<?php
/**
 * Created by BrainMaestro
 * Date: 10/2/2016
 * Time: 10:30 PM
 */

namespace Fce\Repositories\Contracts;

interface SchoolRepository
{
    public function getSchools();

    public function getSchoolById($id);

    public function updateSchool($id, array $attributes);

    public function createSchool(array $attributes);
}