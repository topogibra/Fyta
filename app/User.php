<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable;

    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    protected $table = 'user';
    static $CUSTOMER = 'Customer';
    static $MANAGER = 'Manager';
    static $GUEST = 'Guest';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password_hash', 'address', 'date', 'user_role', 'picture'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password_hash'
    ];

    public function image()
    {
        return $this->hasOne('App\Image', 'id','id_image');
    }

    public function shoppingCart()
    {
        return $this->belongsToMany('App\Product', 'shopping_cart')->withPivot('quantity');
    }


    public function tickets()
    {
        return $this->hasMany('App\Ticket', 'id_user');
    }


    public function ticketMessage()
    {
        return $this->hasMany('App\TicketMessage', 'id_user');
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password_hash;
    }

    public function orders()
    {
        return $this->hasMany('App\Order','id_user');
    }

    public function wishlists()
    {
        return $this->hasMany('App\Wishlist','id_user');
    }

    public function getManagersInfo($page)
    {
        $managers = DB::table('user')
                        ->select('user.username','user.date','image.img_name', 'user.id', 'image.description as alt')
                        ->join('image','image.id', '=','user.id_image')
                        ->where('user_role','=','Manager')
                        ->where('user.id','<>',$this->id)
                        ->limit(10)
                        ->offset($page * 10)
                        ->get();

        return $managers;
       
    }

    public static function validateCustomer()
    {
        $role = self::checkUser();
        if($role == self::$GUEST) {
            return 401;
        }
        else if($role == self::$MANAGER)
            return 403;
        
        return null;
    }

    public static function checkUser()
    {
        if(!Auth::check())
            return self::$GUEST;

        $user = Auth::user();
        if($user->user_role != 'Customer')
            return self::$MANAGER;
        else
            return self::$CUSTOMER;
    }

    public static function isFavorited($product_id){
        if(!Auth::check()){
            return false;
        }
        $user = Auth::user();
        return $user->wishlists()->first()->products()->where('id',$product_id)->exists() != null;
    }

}
