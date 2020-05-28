<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use App\Image;
use App\Wishlist;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public static function getValidator(array $data)
    {
        return Validator::make($data, [
            'username' => 'required|string|max:255|unique:user',
            'email' => 'required|string|email|max:255|unique:user',
            'password' => 'required|string|min:6',
            'birthday' => 'required|date',
            "address" => 'required|string|max:255',
            'security-question' => 'required|string'
        ]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return self::getValidator($data);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {

        $user = new User;
        $user->username = $data['username'];
        $user->email= $data['email'];
        $user->password_hash= bcrypt($data['password']);
        $user->address= $data['address'];
        $user->date= $data['birthday'];
        $user->user_role= 'Customer';
        $user->security_question = $data['security-question'];

        $file = Input::file('img');
        if ($file != null){
            $path = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move('img/', $path);

            $img = new Image;
            $img->img_name = $path;
            $img->description = $user->username;
            $img->save();
            $user->id_image = $img->id;
        }

        $user->save();
        
        $wishlist = new Wishlist();
        $wishlist->name = 'Favorites';
        $wishlist->id_user = $user->id;

        $wishlist->save();
        
        return $user;
    }
}
