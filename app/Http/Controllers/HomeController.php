<?php

namespace Fce\Http\Controllers;

use Fce\Repositories\IEvaluationsRepository;
use Fce\Repositories\IUsersRepository;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $users_repository;
    protected $evaluations_repository;

    public function __construct(
        Request $request,
        IUsersRepository $usersRepository,
        IEvaluationsRepository $evaluationsRepository
    ) {
        $this->users_repository = $usersRepository;
        $this->evaluations_repository = $evaluationsRepository;
        parent::__construct($request);
    }

    public function index()
    {
        try {

        } catch (\Exception $e) {
            return $this->errorInternalError($e->getMessage());
        }
    }

    public function login()
    {
        try {

        } catch (\Exception $e) {
            return $this->errorInternalError($e->getMessage());
        }
    }

    public function logout()
    {
        try {

        } catch (\Exception $e) {
            return $this->errorInternalError($e->getMessage());
        }
    }
}
