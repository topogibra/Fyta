<?php

namespace App\Policies;

use App\Order;
use App\User;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class OrderPolicy
{
    use HandlesAuthorization;

    public function create(User $user)
    {
        return Auth::check() && $user->user_role == User::$CUSTOMER;
    }

    public function delete(User $user)
    {
        return Auth::check() && $user->user_role == User::$MANAGER;
    }

    public function update(User $user)
    {
        return Auth::check() && $user->user_role == User::$MANAGER;
    }

    public function show(User $user, Order $order)
    {
        return Auth::check() && ($user->user_role == User::$MANAGER || $user->id == $order->id_user);
    }


}
