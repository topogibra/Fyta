<?php

namespace App\Http\Controllers;

class InvoiceController extends Controller{
    public function invoice($order_id)
    {
        $products_image = Order::products()->belongsTo(Image::products(),'id_product');
        
        $products = $products_image 
            ->select('name','price','quantity','img_hash')
            ->where('order.id', '=', $order_id)
            ->get();

        $sum = 0;
        foreach ($products as $p) {
            $sum += $p->select('price') *  $p->select('quantity');
        }

        $order_info = Order::user()
                        ->select('shipping_id','order_date','user.username','user.address')
                        ->where('user_id', '=', 4)
                        ->get();
        return view('pages.invoice', [ $order_info, 'location' => 'Calgary, Canada', 'sum' => $sum, 'delivery' => 'FREE', 'items' => $products]);
    }
}