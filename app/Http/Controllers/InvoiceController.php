<?php

namespace App;
namespace App\Http\Controllers;

use App\Product;
use App\Order;


class InvoiceController extends Controller{
    
    public function invoice($id)
    {
        $products = Product::getOrderProducts($id);
        $information = Order::getOrderInformation($id);
        $status = Order::getOrderStatus($id);

        $sum = 0;
        foreach($products as $product)
        {
            $sum += $product->quantity * $product->price;
        }

        return view('pages.invoice', ['information' => $information, 'location' => 'Calgary, Canada', 'status'=> $status,'sum' => $sum, 'delivery' => 'FREE', 'items' => $products]);
    }
}