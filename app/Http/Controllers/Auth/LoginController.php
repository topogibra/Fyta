<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

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

    public function getUser(Request $request)
    {
        return $request->user();
    }

    public function home()
    {
        return redirect('login');
    }


    public function passwordRecovery()
    {

        $role = User::checkUser();

        if ($role != User::$GUEST) {
            return redirect('/');
        }

        return view('pages.password_recovery');
    }


    public function recoverPassword(Request $request)
    {

        $request->validate([
            'email' => 'required|string|email|max:255',
            'security-question' => 'required|string'
        ]);

        $role = User::checkUser();

        if ($role != User::$GUEST) {
            return redirect('/');
        }

        $user = User::where('email', '=', $request->input('email'))->get()->first();

        if($user == null){
            return redirect()->back()->withErrors(['msg' => 'Email not found']);
        }

        if(trim($user->security_question) != trim($request->input('security-question'))){
            return redirect()->back()->withErrors(['msg' => 'Security Answer was wrong.']);
        }

        
        $request->session()->put('change_password', $user->id);
        return redirect('/change-password');
    }


    public function passwordChange(Request $request)
    {

        $role = User::checkUser();

        if ($role != User::$GUEST && !$request->session()->get('change_password', false)) {
            return redirect('/');
        }

        return view('pages.change_password');
    }


    public function changePassword(Request $request)
    {

        $request->validate([
            'password' => 'required|string|min:6'
        ]);

        $role = User::checkUser();

        if ($role != User::$GUEST && !$request->session()->get('change_password', false)) {
            return redirect('/');
        }

        $user = User::find($request->session()->pull('change_password', false));

        $user->password_hash = bcrypt($request->input('password'));
        $user->save();

        return redirect('/login');
    }
}
