<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Foundation\Http\Exceptions\MaintenanceModeException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param \Exception $exception
     * @return void
     * @throws Exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Exception $exception
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws Exception
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof \Spatie\Permission\Exceptions\UnauthorizedException) {
            return $this->unauthorizedException($exception);
        }

        if ($exception instanceof MaintenanceModeException) {
            return $this->maintenanceModeException($exception);
        }

        if ($exception instanceof NotFoundHttpException) {
            return $this->notFoundHttpException($exception);
        }

        if ($exception instanceof HttpException && $exception->getStatusCode() == 403) {
            return response()->view('front.errors.403', [], 403);
        }

        if ($exception instanceof HttpException) {
            return $this->httpException($exception, $request);
        }


        return parent::render($request, $exception);
    }

    private function maintenanceModeException(Exception $exception)
    {
        return response()->view('Front.errors.maintenance', [], 503);
    }

    private function notFoundHttpException(Exception $exception)
    {
        return response()->view('Front.errors.404', [
            'error' => ' Ooops, we cannot find what you are looking for. Please try again.',
        ], 404);
    }

    private function httpException(Exception $exception, Request $request)
    {
        Log::info($exception->getMessage());
        return (Str::contains($request->url(), '/admin/'))
            ? response()->view('admin.errors.error', [
                'error' => ' Ooops, server error occurred Please check again later.',
                'code' => $exception->getCode()
            ], 500)
            : response()->view('Front.errors.500', ['exception' => $exception]);

    }

    private function unauthorizedException(Exception $exception)
    {
        return response()->view('admin.errors.error', [
            'error' => 'accessing the page or resource you were trying to reach is forbidden for some reason',
            'code' => '403'
        ], 403);
    }
}
