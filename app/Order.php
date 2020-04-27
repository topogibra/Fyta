<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    protected $table = 'order';
    public $timestamps  = false;

    public function user()
    {
        return $this->belongsTo('App\User', 'id_user');
    }

    public function products()
    {
        return $this->belongsToMany('App\Product', 'product_order', 'id_order', 'id_product')->withPivot('quantity');
    }

    public function history()
    {
        return $this->hasMany('App\OrderHistory', 'id_order');
    }

    public static function getOrderInformation($order_id)
    {
        $information = DB::table('order')
            ->select('order.shipping_id as shipping_id', 'order.delivery_address as address', 'order.order_date as date', 'user.username as name')
            ->join('user', 'user.id', '=', 'order.id_user')
            ->where('order.id', '=', $order_id)
            ->first();

        $address = explode(" ", $information->address);
        $address_size = count($address);
        $address1 = array_splice($address, 0, $address_size - 2);
        $information->address = implode(" ", $address1);
        $information->location = (count($address) - 2) < 0 ? "" : $address[count($address) - 2] . " " . $address[count($address) - 1];



        return $information;
    }

    public static function getOrderStatus($order_id)
    {
        $status = DB::table('order_history')
            ->select('order_status as status')
            ->where('order_history.id_order', '=', $order_id)
            ->orderByDesc('order_history.date')
            ->first();

        $status->status = str_replace("_", " ", $status->status);
        return $status;
    }

    public static function getStatusOrders()
    {
        $status = DB::select('select "order"."shipping_id", "order"."order_date", "order"."id" as "order_id", 
                                    (select order_status from order_history where order_history.id_order = "order".id order by order_history.date DESC
                                    limit 1) as "order_status"
                                from "order" where 
                                (select count(*) from order_history where order_history.id_order = "order".id and order_status = \'Processed\' ) = 0
                ');
        return $status;
    }
}
