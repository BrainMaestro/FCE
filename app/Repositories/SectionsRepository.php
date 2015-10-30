<?php
/**
 * Created by PhpStorm.
 * User: Cheezzy Tenorz
 * Date: 10/29/2015
 * Time: 8:04 PM
 */

namespace Fce\Repositories;

use Fce\Models\Evaluation;
use Fce\Models\Question;
use Fce\Models\QuestionSet;
use Fce\Models\Section;

class SectionsRepository extends AbstractRepository implements ISectionsRepository
{
    protected $section_model;
    protected $evaluation_model;
    protected $question_set_model;
    protected $question_model;

    public function __construct(Section $section, Evaluation $evaluation, QuestionSet $questionSet, Question $question)
    {
        $this->section_model = $section;
        $this->evaluation_model = $evaluation;
        $this->question_set_model = $questionSet;
        $this->question_model = $question;
    }

    public function getSections($data)
    {
        try {
            Paginator::currentPageResolver(
                function () use ($data) {
                    return $data['offset'];
                }
            );
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function getSectionById($section_id)
    {
        try {

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function createSection($data)
    {
        try {

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function updateSection($data)
    {
        try {

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function getSectionEvaluationBySectionId($section_id)
    {
        try {

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function getSectionEvaluationByQuestionSet($question_set_id)
    {
        try {

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
