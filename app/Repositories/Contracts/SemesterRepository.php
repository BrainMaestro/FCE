<?php
/**
 * Created by BrainMaestro
 * Date: 10/2/2016
 * Time: 10:19 PM.
 */
namespace Fce\Repositories\Contracts;

interface SemesterRepository
{
    public function getSemesters();

    public function getCurrentSemester();

 /* We might remove this when we find cleaner way to use getSemesterById */

    public function getSemesterById($id);

    public function setCurrentSemester($id, $status = true);

    public function createSemester($season, $year, $currentSemester = false);

    public function addQuestionSet($id, $questionSetId, $evaluationType);

    public function setQuestionSetStatus($id, $questionSetId, $status);

    public function getOpenQuestionSet($id);
}
