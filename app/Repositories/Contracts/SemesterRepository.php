<?php
/**
 * Created by BrainMaestro
 * Date: 10/2/2016
 * Time: 10:19 PM
 */

namespace Fce\Repositories\Contracts;

interface SemesterRepository
{
    public function getSemesters();

    public function getCurrentSemester();

    public function setCurrentSemester($id, $status = true);

    public function createSemester($season, $year, $currentSemester = false);

    public function addQuestionSet($id, $questionSetId, array $attributes);

    public function getQuestionSets($id);

    public function setQuestionSetStatus($id, $questionSetId, $status);
}