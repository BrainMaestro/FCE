<?php
/**
 * Created by BrainMaestro
 * Date: 10/2/2016
 * Time: 11:09 PM
 */

namespace Fce\Repositories;

interface EvaluationRepository
{
    public function getEvaluationsBySectionAndQuestionSet($sectionId, $questionSetId);

    public function getEvaluationBySectionQuestionSetAndQuestion($sectionId, $questionSetId, $questionId);

    public function createEvaluation(array $attributes);

    public function incrementEvaluation($id, $column);
}