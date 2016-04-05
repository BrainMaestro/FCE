<?php

/**
 * Created by BrainMaestro.
 * Date: 4/4/16
 * Time: 2:02 PM.
 */
namespace Fce\Http\Middleware;

use Closure;
use JWTFactory;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Tymon\JWTAuth\Support\Utils;

class RefreshToken extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            // If token has expired, refresh it.
            if (Utils::isPast(JWTFactory::exp())) {
                $token = $this->auth->parseToken()->refresh();
            }
        } catch (JWTException $e) {
            throw new UnauthorizedHttpException('jwt-auth', $e->getMessage(), $e, $e->getCode());
        }

        $response = $next($request);

        // Send the refreshed token back to the client.
        if (isset($token)) {
            $response->headers->set('Authorization', 'Bearer ' . $token);
        }

        return $response;
    }
}
