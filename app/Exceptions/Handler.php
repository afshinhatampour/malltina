<?php

namespace App\Exceptions;

use App\Traits\ApiResponderTrait;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class Handler extends ExceptionHandler
{
    use ApiResponderTrait;

    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->renderable(function (AccessDeniedHttpException $e) {
            return $this->success($e->getMessage(), [
                'message' => config('app.env') === 'production' ? $e->getMessage() : $e->getTrace(),
                'code'    => $e->getStatusCode()
            ], $e->getStatusCode());
        });
    }
}
