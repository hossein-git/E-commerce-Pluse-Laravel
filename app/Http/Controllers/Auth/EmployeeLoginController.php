<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use http\Env\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class EmployeeLoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;


    /**
     * Show the application's login form.
     *
     * @return Response
     */
    public function showLoginForm()
    {
        return view('admin.log-in');
    }


    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * The user has been authenticated.
     * if user had role redirect to user index in admin panel
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(\Illuminate\Http\Request $request, $user)
    {

//        if (auth()->user()->getRoleNames()->count()) {
//            return redirect()->route('user.index');
//        }
//        if ($request->has('before_checkout_form')){
//           return redirect()->route('front.checkout');
//        }
    }

    /**
     * Validate the user login request.
     * if a bot filed input then return false
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     *
     * @throws ValidationException
     */

    protected function validateLogin(\Illuminate\Http\Request $request)
    {
        if ($request->input('input')){
            return false;
        }
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }
}
