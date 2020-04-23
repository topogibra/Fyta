<?php

namespace App\Policies;

use App\Order;
use App\User;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class UserPolicy
{
    use HandlesAuthorization;

    public function updateCustomer(User $user)
    {  
        return Auth::check() && $user->user_role == User::$CUSTOMER;
    }

    public function updateManager(User $user)
    {
        return Auth::check() && $user->user_role == User::$MANAGER;
    }

}