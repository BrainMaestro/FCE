<?php
/**
 * Created by PhpStorm.
 * User: Cheezzy Tenorz
 * Date: 10/29/2015
 * Time: 8:00 PM
 */

namespace Fce\Repositories;

interface ISectionsRepository
{
    public function getSections($data);

    public function getSectionById($section_id);

    public function createSection($data);

    public function updateSection($data);

    public function getSectionEvaluationBySectionId($section_id);

    public function getSectionEvaluationByQuestionSet($question_set_id);

}