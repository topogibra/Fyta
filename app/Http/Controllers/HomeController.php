<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{

    public function __construct()
    {
    }

    public function render()
    {
        return view('pages.home', ['items' => ['top-deals' =>  [['img' => "img/orquideas.jpg", 'name' => "Rose Orchid", 'price' => "20€"], ['img' => "img/vaso.jpg", 'name' => "XPR Vase", 'price' => "15€"], ['img' => "img/bonsai2.jpg", 'name' => "Bonsai CRT", 'price' => "35€"], ['img' => "img/tulipas.jpg", 'name' => "Orange Tulips", 'price' => "10€"]], 'indoor-plants' => [['img' => "img/meatrose_indoor.jpg", 'name' => "Meat Rose", 'price' => "30€"], ['img' => "img/reddahlia_indoor.jpg", 'name' => "Red Dahlias", 'price' => "13.99€"], ['img' => "img/pinktulips_indoor.jpg", 'name' => "Pink Tulips", 'price' => "16.50€"], ['img' => "img/sativa_indoor.jpg", 'name' => "Sativa Prime", 'price' => "4.20€"]], 'outdoor-plants' => [['img' => "img/greenpalm_outdoor.jpg", 'name' => "Green Palm Tree", 'price' => "80€"], ['img' => "img/lavender_outdoor.jpg", 'name' => "Lavender Premium", 'price' => "25€"], ['img' => "img/pondlilies_outdoor.jpg", 'name' => "Pond White Lilies", 'price' => "40€"], ['img' => "img/sunflower_outdoor.jpg", 'name' => "Sunny's Sunflowers", 'price' => "30€"]], 'top-vases' => [['img' => "img/babyblue_vase.jpg", 'name' => "Baby Blue Vase", 'price' => "10€"], ['img' => "img/blackplastic_vase.jpg", 'name' => "Black Vase", 'price' => "6€"], ['img' => "img/blueceramic_vase.jpg", 'name' => "Ceramic Pot", 'price' => "11.99€"], ['img' => "img/supreme_vase.jpg", 'name' => "Supreme Bonsai Pot", 'price' => "40€"]], 'top-tools' => [['img' => "img/mower_tool.jpg", 'name' => "High-tech mower", 'price' => "69.99€"], ['img' => "img/gloves_tool.jpg", 'name' => "Blue Garden Gloves", 'price' => "9€"], ['img' => "img/orangecut_tool.jpg", 'name' => "Electric Grass Cutter", 'price' => "27€"], ['img' => "img/watercan_tool.jpg", 'name' => "Green Watercan 12l", 'price' => "5€"]]]]);
    }
}
