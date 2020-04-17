<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

class LoginController extends Controller
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
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function getUser()
    {
        return $request->user();
    }

    public function home()
    {
        return redirect('login');
    }

    public function login(Request $request)
    {
        if(Auth::check()){
            return redirect()->back();
        }

        $rules = array(
            'loginEmail'    => 'required|string|email|max:255',
            'loginPassword' => 'required|string|min:6'
        );

        $validator = Validator::make($request->input(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput(Input::except('loginPassword'));
        } else {
            $userdata = [
                "email" => $request->input("loginEmail"),
                "password" => $request->input("loginPassword")
            ];


            //try to login
            if (Auth::attempt($userdata)) {
                return redirect('/home');
            } else {
                return redirect('/profile');
            }
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('login');
    }
}
