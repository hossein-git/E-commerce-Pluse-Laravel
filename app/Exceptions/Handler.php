<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
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
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {

        if ($exception instanceof \Spatie\Permission\Exceptions\UnauthorizedException) {
            return response()->view('admin.errors.error', [
                'error' => 'accessing the page or resource you were trying to reach is forbidden for some reason',
                'code' => '403'
            ], 403);
        }
        if ($exception instanceof NotFoundHttpException) {

            return response()->view('Front.errors.404',[
                    'error' => ' Ooops, we cannot find what you are looking for. Please try again.',
                ],404);

        } elseif ($exception instanceof HttpException && $exception->getStatusCode() == 403) {
            return response()->view(
                'front.errors.403');

        } elseif ($exception instanceof HttpException) {
            Log::info($exception->getMessage());
            return (Str::contains($request->url(), '/admin/'))
                ? response()->view('admin.errors.403', [
                    'error' => ' Ooops, server error occurred Please check again later.',
                    'code' => '500'
                ], 500)
                : response()->view('Front.errors.500');

        }
        return parent::render($request, $exception);
    }
}
