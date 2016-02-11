<?php
/**
 * Created by BrainMaestro
 * Date: 10/2/2016
 * Time: 10:19 PM
 */

namespace Fce\Repositories;

interface SemesterRepository
{
    public function getSemesters();

    public function getCurrentSemester();

    public function setCurrentSemester($id);

    public function createSemester(array $attributes);
}