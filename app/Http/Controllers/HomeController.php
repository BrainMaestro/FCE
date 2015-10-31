<?php

namespace Fce\Http\Controllers;

use Fce\Repositories\UsersRepository;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $repository;

    public function __construct(Request $request, UsersRepository $usersRepository)
    {
        $this->repository = $usersRepository;
        parent::__construct($request);
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
