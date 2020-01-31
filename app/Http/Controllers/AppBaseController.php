<?php

namespace App\Http\Controllers;


use App\Helpers\ResponseUtil;
use Illuminate\Support\Facades\Response;
use Laracasts\Flash\Flash;

class AppBaseController extends Controller
{
    /**
     * @param $result
     * @param $message
     * @return mixed
     */
    public function sendResponse($result, $message)
    {
        return Response::json(ResponseUtil::makeResponse($message, $result));
    }

    /**
     * @param $error
     * @param int $code
     * @return mixed
     */
    public function sendError($error, $code = 404)
    {
        return Response::json(ResponseUtil::makeError($error), $code);
    }

    /**
     * @param $message
     * @param int $code
     * @return mixed
     */
    public function sendSuccess($message, $code = 200)
    {
        return Response::json([
            'success' => true,
            'message' => $message
        ], $code);
    }

}