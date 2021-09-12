<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Nette\Schema\ValidationException;
use Illuminate\Support\Facades\Log;
    use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * @param Throwable $e
     * @throws Throwable
     */
    public function report(Throwable $e)
    {
        parent::report($e);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param Throwable $exception
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|\Symfony\Component\HttpFoundation\Response
     * @throws Throwable
     */
    public function render($request, Throwable $exception)
    {
        $rendered = parent::render($request, $exception);

        Log::error($exception);

        if ($exception instanceof ValidationException) {
            $json = [
                'error' => $exception->validator->errors(),
            ];
        } elseif ($exception instanceof AuthorizationException) {
            $json = [
                'error' => trans('message.permission_denied'),
            ];
        } elseif ($exception instanceof NotFoundHttpException) {
            $json = [
                'error' => trans('message.page_not_found'),
            ];
        } else {
            // Default to vague error to avoid revealing sensitive information
            $json = [
                'error' => (app()->environment() !== 'production')
                    ? $exception->getMessage()
                    : trans('message.an_error_has_occurred'),
            ];
        }

        return response()->json($json, $rendered->getStatusCode());
    }
}
