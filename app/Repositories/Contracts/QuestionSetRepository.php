<?php
/**
 * Created by BrainMaestro
 * Date: 10/2/2016
 * Time: 10:38 PM
 */

namespace Fce\Repositories\Contracts;

interface QuestionSetRepository
{
    public function getQuestionSets();

    public function getQuestionSetById($id);

    public function createQuestionSet($name);

    public function addQuestions($id, array $questions);
}