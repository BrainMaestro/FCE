<?php
/**
 * Created by BrainMaestro
 * Date: 10/2/2016
 * Time: 10:24 PM.
 */
namespace Fce\Repositories\Contracts;

interface SectionRepository
{
    public function getSectionsBySemester($semesterId, $all = false);

    public function getSectionsBySemesterAndSchool($semesterId, $schoolId);

    public function getSectionById($id);

    public function createSection(array $attributes);

    public function updateSection($id, array $attributes);

    public function setSectionStatus($id, $status);
}
