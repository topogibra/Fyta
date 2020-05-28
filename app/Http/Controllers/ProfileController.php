<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\RegisterController;
use App\Image;
use DateTime;
use App\Product;
use App\Order;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;


class ProfileController extends Controller
{
    public function profile(Request $request)
    {
        $role = User::checkUser();
        if ($role == User::$GUEST)
            return response()->json(['message' => 'You must login to access your profile'], 401);

        if ($request->path() == 'manager/get' && $role != User::$MANAGER)
            return response()->json(['message' => 'You do not have access to this section'], 403);

        if ($request->path() == 'profile/get' && $role != User::$CUSTOMER)
            return response()->json(['message' => 'Managers can\'t access customer profile'], 403);

        $user = Auth::user();
        $img = $user->image()->first();
        if (!$img)
            $photo = 'img/user.png';
        else
            $photo = 'img/' . $img->img_name;

        if ($user->user_role == 'Customer') {
            $date = new DateTime($user->date);
            $year = $date->format('Y');
            $month = $date->format('M');
            $day = $date->format('d');
            $data = ['username' => $user->username, 'email' => $user->email, 'address' => $user->address,
                     'year' => $year, 'month' => $month, 'day' => $day, 'photo' => $photo, 'security_question' => $user->security_question];
        } else {
            $data = ['username' => $user->username, 'email' => $user->email, 'photo' => $photo];
        }

        return $data;
    }

    protected function storeNewPhoto(User $user, UploadedFile $file)
    {
        $path = uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move('img/', $path);

        $img = new Image;
        $img->img_name = $path;
        $img->description = $user->username;
        $img->save();

        $user->id_image = $img->id;
    }

}
