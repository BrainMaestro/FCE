<?php

namespace Fce\Http\Controllers;

use Fce\Repositories\ISemestersRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class SemesterController extends Controller
{
    protected $repository;

    public function __construct(Request $request, ISemestersRepository $semestersRepository)
    {
        $this->repository = $semestersRepository;
        parent::__construct($request);
    }

    public function index()
    {
        try {
            $fields['query'] = Input::get('query', null);
            $fields['sort'] = Input::get('sort', 'created_at');
            $fields['order'] = Input::get('order', 'ASC');
            $fields['limit'] = Input::get('limit', 10);
            $fields['offset'] = Input::get('offset', 1);


        } catch (\Exception $e) {
            return $this->errorInternalError($e->getMessage());
        }
    }

    public function showCurrentSemester()
    {
        try {

        } catch (\Exception $e) {
            return $this->errorInternalError($e->getMessage());
        }
    }

    public function create()
    {
        try {

        } catch (\Exception $e) {
            return $this->errorInternalError($e->getMessage());
        }
    }

    public function update($id)
    {
        try {

        } catch (\Exception $e) {
            return $this->errorInternalError($e->getMessage());
        }
    }
}
