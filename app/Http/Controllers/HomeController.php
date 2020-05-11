<?php

namespace App\Http\Controllers;

use App\Product;

class HomeController extends Controller
{

    public function __construct()
    {
    }

    public function render()
    {
        $deals = Product::getTopSales();
        $indoor = Product::getTopByTag('Indoor');
        $outdoor = Product::getTopByTag('Outdoor');
        $vases = Product::getTopByTag('Vases');
        $tools = Product::getTopByTag('Tools');
        return view('pages.home', ['items' => [ 'top-deals' => $deals, 'indoor-plants' => $indoor, 'outdoor-plants' => $outdoor, 'top-vases' => $vases, 'top-tools' => $tools]]);
    }

    public function root()
    {
        return redirect('home');
    }
}
