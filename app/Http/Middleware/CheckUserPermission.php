<?php

namespace Fce\Http\Middleware;

use Closure;
use Fce\Utility\ApiClient;
use Fce\Utility\PermissionCheck;

class CheckUserPermission
{
    use ApiClient, PermissionCheck;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->checkPermission($request)) {
            return $next($request);
        }

        return $this->respondUnauthorized('You do not have the required permission for this route');
    }
}
