<?php
/**
 * Created by BrainMaestro
 * Date: 10/2/2016
 * Time: 10:34 PM
 */

namespace Fce\Repositories\Contracts;

interface QuestionRepository
{
    public function getQuestions();

    public function getQuestionById($id);

    public function createQuestion($description, $category = null, $title = null);
}