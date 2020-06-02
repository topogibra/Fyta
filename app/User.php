<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Null_;

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

    public static function getImage()
    {
        $user = Auth::user();
        $image = DB::table('user')
                    ->select('image.img_name as img_name')
                    ->join('image','image.id', '=','user.id_image')
                    ->where('user.id','=',$user->id)
                    ->first();

        if($image == null)
            return "img/user.png";
            
        $image->img_name = "img/" . $image->img_name;
        return $image->img_name;

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

    public function getProcessedOrders($product_id){
        $user_id = $this->id;

        $processedOrders = DB::table('product_order')
                            ->select('order.id', 'order.shipping_id', 'order.order_date')
                            ->join('order_history',function($join){
                                $join->on("order_history.id_order","=","product_order.id_order")
                                     ->whereRaw("order_history.order_status='Processed'");
                            })
                            ->leftJoin("review",function($join) use ($product_id){
                                $join->on("order_history.id_order", "=", "review.id_order")
                                     ->where("review.id_product", "=", $product_id);
                            })
                            ->join('order','order.id',"=",'order_history.id_order')
                            ->where("product_order.id_product","=",$product_id)
                            ->where('order.id_user',"=",$user_id)
                            ->where(function($query){
                                $query->whereNull('review.id_product')
                                      ->orWhereNull('review.id_order');
                            }
                        )->get();
        return $processedOrders;
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
