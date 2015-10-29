<?php
/**
 * Created by PhpStorm.
 * User: Cheezzy Tenorz
 * Date: 10/29/2015
 * Time: 7:26 PM
 */

namespace Fce\Repositories;

use Fce\Models\Evaluation;
use Fce\Models\Key;
use Fce\Models\Section;
use Illuminate\Pagination\Paginator;

class EvaluationsRepository extends AbstractRepository implements IEvaluationsRepository
{
    protected $evaluation_model;
    protected $section_model;
    protected $key_model;

    public function __construct(Evaluation $evaluation, Section $section, Key $key)
    {
        $this->evaluation_model = $evaluation;
        $this->section_model = $section;
        $this->key_model = $key;
    }

    public function getEvaluationSections($data)
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

    public function getEvaluationSectionQuestionsBySetId($question_set_id)
    {
        try {

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function getEvaluationSectionKeysBySectionId($section_id)
    {
        try {

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function createEvaluation($data)
    {
        try {

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
