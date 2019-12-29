<?php

namespace App\Exceptions;


use Exception;
use Illuminate\Http\Request;

class SessionExpiredException extends Exception
{
    public function report()
    {

    }


    public function render(Request $request)
    {
        return response()->view('Front.errors.440')->setStatusCode(440,'session expired');

    }

}