<?php
/**
 * Created by PhpStorm.
 * User: Cheezzy Tenorz
 * Date: 10/29/2015
 * Time: 8:39 PM
 */

namespace Fce\Repositories;

interface ISemestersRepository
{
    public function getSemesters($data);

    public function getCurrentSemester();

    public function setCurrentSemester($semester_id);

    public function createSemester($data);
}
