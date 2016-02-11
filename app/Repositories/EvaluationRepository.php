<?php
/**
 * Created by BrainMaestro
 * Date: 10/2/2016
 * Time: 11:09 PM
 */

namespace Fce\Repositories;

interface EvaluationRepository
{
    public function getEvaluationsBySectionId($sectionId);

    public function createEvalution(array $attributes);

    public function updateEvaluation($id, array $attributes);
}