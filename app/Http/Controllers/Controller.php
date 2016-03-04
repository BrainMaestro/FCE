<?php

namespace Fce\Http\Controllers;

use Fce\Traits\ApiClient;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, ApiClient;

    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
}
