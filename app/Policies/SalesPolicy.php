<?php

namespace App\Policies;

use App\Discount;
use App\User;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class SalesPolicy
{
    use HandlesAuthorization;

    public function upsert(User $user,Discount $discount)
    {
        return Auth::check() && $user->user_role == User::$MANAGER;
    }

    public function delete(User $user)
    {
        return Auth::check() && $user->user_role == User::$MANAGER;
    }

    public function show(User $user)
    {
        return Auth::check() && $user->user_role == User::$MANAGER;
    }
}
