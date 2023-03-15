<?php

namespace App\Exceptions;

use App\Responses\ApiResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];


    public function render($request, Throwable $exception)
    {
        if ($exception instanceof AccessDeniedHttpException) {
            return ApiResponse::error('Forbidden.', ['error' => 'Forbidden'], 403)->toJson();
        }

        if ($exception instanceof MethodNotAllowedHttpException) {
            return ApiResponse::error('Method not allowed.', ['error' => 'Method not allowed'], 405)->toJson();
        }

        if ($exception instanceof UnauthorizedHttpException) {
            return ApiResponse::error('Unauthenticated.', ['error' => 'Unauthenticated'], 401)->toJson();
        }

        if ($exception instanceof AuthenticationException) {
            return ApiResponse::error('Unauthenticated.', ['error' => 'Unauthenticated'], 401)->toJson();
        }

        if ($exception instanceof NotFoundHttpException) {
            return ApiResponse::error('Not found.', ['error' => 'Not found'], 404)->toJson();
        }

        if ($exception instanceof ModelNotFoundException) {
            return ApiResponse::error('Not found.', ['error' => 'Not found'], 404)->toJson();
        }
        return parent::render($request, $exception);
    }
}
