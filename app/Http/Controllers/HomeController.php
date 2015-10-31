<?php

namespace Fce\Http\Controllers;

use Fce\Repositories\EvaluationsRepository;
use Fce\Repositories\UsersRepository;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $users_repository;
    protected $evaluations_repository;

    public function __construct(
        Request $request,
        UsersRepository $usersRepository,
        EvaluationsRepository $evaluationsRepository
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
