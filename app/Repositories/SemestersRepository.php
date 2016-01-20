<?php
/**
 * Created by PhpStorm.
 * User: Cheezzy Tenorz
 * Date: 10/29/2015
 * Time: 8:41 PM
 */

namespace Fce\Repositories;

use Fce\Models\Section;
use Fce\Models\Semester;
use Fce\Transformers\SemesterTransformer;
use Illuminate\Pagination\Paginator;

class SemestersRepository extends AbstractRepository implements ISemestersRepository
{
    protected $semester_model;

    public function __construct(Semester $semester)
    {
        $this->semester_model = $semester;
    }

    public function getSemesters($data)
    {
        try {
            Paginator::currentPageResolver(
                function () use ($data) {
                    return $data['offset'];
                }
            );

            if (is_null($data['query'])) {
                $semesters = $this->semester_model->orderBy($data['sort'].$data['order'])
                    ->paginate($data['limit']);
            } else {
                $semesters = $this->semester_model->where('crn', 'like', '%'.$data['query'].'%')
                    ->orderBy($data['sort'].$data['order'])
                    ->paginate($data['limit']);
            }

            if ($semesters->isEmpty()) {
                return null;
            } else {
                $semesters = self::setPaginationLinks($semesters, $data);
                return self::transform($semesters, new SemesterTransformer());
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function getCurrentSemester()
    {
        try {

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function setCurrentSemester($semester_id)
    {
        try {

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function createSemester($data)
    {
        try {

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
