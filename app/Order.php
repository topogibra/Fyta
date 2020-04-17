<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    public $timestamps  = false;
    
    protected $table = 'order';

    public function user()
    {
        return $this->belongsTo('App\User', 'id_user');
    }

    public function products()
    {
        return $this->belongsToMany('App\Product', 'product_order')->withPivot('quantity');
    }

    public function history()
    {
        return $this->hasMany('App\OrderHistory', 'id_order');
    }

    public static function getOrderInformation($order_id)
    {
        $information = DB::table('order')
            ->select('order.shipping_id as shipping_id','order.delivery_address as address','order.order_date as date','user.username as name')
            ->join('user','user.id', '=', 'order.id_user')
            ->where('order.id', '=',$order_id)
            ->first();
        
        return $information;
    }

    public static function getOrderStatus($order_id)
    {
        $status = DB::table('order_history')
            ->select('order_status as status')
            ->where('order_history.id_order', '=', $order_id)
            ->first();
        
        return $status;
    }


}
