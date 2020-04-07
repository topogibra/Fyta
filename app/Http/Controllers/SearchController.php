<?php

namespace App\Http\Controllers;

class SearchController extends Controller{
    public function render()
    {
        return view('pages.search', ['categories' => array("Anthuriums", "Artificial", "Bulbs", "Gardenias", "Orchids"), 'sizes' =>  array("0kg-0.2kg", "0.2kg-0.5kg", "0.5-1.5kg", "1.5kg-3kg", "&gt; 3kg"), 'items' => [['img' => "img/orquideas.jpg", 'name' => "Rose Orchid", 'price' => "20€"], ['img' => "img/vaso.jpg", 'name' => "XPR Vase", 'price' => "15€"], ['img' => "img/bonsai2.jpg", 'name' => "Bonsai CRT", 'price' => "35€"], ['img' => "img/tulipas.jpg", 'name' => "Orange Tulips", 'price' => "10€"]]]);
    }
}