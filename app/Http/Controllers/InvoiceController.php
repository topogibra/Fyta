<?php

namespace App;
namespace App\Http\Controllers;

use App\Product;
use App\Order;


class InvoiceController extends Controller{
    
    public function invoice()
    {
        $products = Product::getOrderProducts(43);
        $information = Order::getOrderInformation(43);
        $status = Order::getOrderStatus(43);

        $sum = 0;
        foreach($products as $product)
        {
            $sum += $product->quantity * $product->price;
        }

        return view('pages.invoice', ['information' => $information, 'location' => 'Calgary, Canada', 'status'=> $status,'sum' => $sum, 'delivery' => 'FREE', 'items' => $products]);
    }
}