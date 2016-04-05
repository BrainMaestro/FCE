<?php

namespace Fce\Exceptions;

use Exception;
use Fce\Utility\ApiClient;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class Handler extends ExceptionHandler
{
    use ApiClient;
    
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        HttpException::class,
        ModelNotFoundException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        return parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if ($e instanceof ModelNotFoundException) {
            return $this->respondNotFound($e->getMessage());
        } elseif ($e instanceof \ReflectionException) {
            return $this->respondUnprocessable('Model does not exist');
        } elseif ($e instanceof MethodNotAllowedHttpException) {
            return $this->respondBadRequest('This Http method is not allowed on this route');
        } elseif ($e instanceof BadRequestHttpException) {
            return $this->respondBadRequest($e->getMessage());
        } elseif ($e instanceof ValidationException) {
            return $this->respondUnprocessable($e->validator->messages());
        } elseif ($e instanceof UnauthorizedHttpException) {
            return $this->respondUnauthorized($e->getMessage());
        } else {
            return $this->respondInternalServerError($e->getMessage());
        }

        // Should only be removed for debugging
        // return parent::render($request, $e);
    }
}
