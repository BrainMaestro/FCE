<?php
/**
 * Created by BrainMaestro
 * Date: 10/2/2016
 * Time: 11:09 PM
 */

namespace Fce\Repositories\Contracts;

interface EvaluationRepository
{
    public function getEvaluationsBySectionAndQuestionSet($sectionId, $questionSetId);

    public function getEvaluationBySectionQuestionSetAndQuestion($sectionId, $questionSetId, $questionId);

    public function createEvaluations($sectionId, array $questionSet);

    public function incrementEvaluation($id, $column);
}