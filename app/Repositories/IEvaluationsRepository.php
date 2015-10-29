<?php
/**
 * Created by PhpStorm.
 * User: Cheezzy Tenorz
 * Date: 10/29/2015
 * Time: 7:21 PM
 */

namespace app\Repositories;

interface IEvaluationsRepository
{
    public function getEvaluationSections($data);

    public function getEvaluationSectionQuestionsBySetId($question_set_id);

    public function getEvaluationSectionKeysBySectionId($section_id);

    public function createEvaluation($data);
}