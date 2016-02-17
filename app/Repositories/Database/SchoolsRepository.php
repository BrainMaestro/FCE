<?php
/**
 * Created by PhpStorm.
 * User: Cheezzy Tenorz
 * Date: 10/29/2015
 * Time: 8:34 PM
 */

namespace Fce\Repositories;

use Fce\Models\School;
use Fce\Transformers\SchoolTransformer;
use Illuminate\Pagination\Paginator;

class SchoolsRepository extends Repository implements ISchoolsRepository
{
    protected $school_model;

    public function __construct(School $school)
    {
        $this->school_model = $school;
    }

    public function getSchools($data)
    {
        try {
            Paginator::currentPageResolver(
                function () use ($data) {
                    return $data['offset'];
                }
            );

            if (is_null($data['query'])) {
                $schools = $this->school_model->orderBy($data['sort'].$data['order'])
                    ->paginate($data['limit']);
            } else {
                $schools = $this->school_model->where('crn', 'like', '%'.$data['query'].'%')
                    ->orderBy($data['sort'].$data['order'])
                    ->paginate($data['limit']);
            }

            if ($schools->isEmpty()) {
                return null;
            } else {
                $schools = self::setPaginationLinks($schools, $data);
                return self::transform($schools, new SchoolTransformer());
            }

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function getSchoolById($school_id)
    {
        try {

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function createSchool($data)
    {
        try {

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function updateSchoolById($school_id)
    {
        try {

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
