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
        $information->location = ($address_size - 2) < 0 ? "" : $address[$address_size - 2] . " " . $address[$address_size - 1];

        return $information;
    }

    public static function getOrderStatus($order_id)
    {
        $status = DB::table('order_history')
            ->select('order_status as status')
            ->where('order_history.id_order', '=', $order_id)
            ->first();

        $status->status = str_replace("_", " ", $status->status);
        return $status;
    }

    public static function getStatusOrders()
    {
        $status = DB::table('order_history')
            ->select('order_history.order_status', 'order.shipping_id', 'order.order_date', 'order.id as order_id')
            ->join('order', 'order.id', '=', 'order_history.id_order')
            ->where('order_history.order_status', '!=', 'Processed')
            ->get();

        return $status;
    }
}
