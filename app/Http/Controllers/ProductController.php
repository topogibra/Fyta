<?php

namespace App\Http\Controllers;

class ProductController extends Controller{
    public function render(){
        return view('pages.product', ['img' => 'img/bonsai.jpg', 'description' => "Have you ever thought of tending a plant? Do you watch asian movies and feel like going into that rich culture? Now you can have a piece of that by ordering one of our premium Bonsai CRT,that will give your home a deep sense of oriental energy.", 'price' => '35€', 'score' => 4.0, 'name' => 'Bonsai CRT', 'related' => [['img' => 'img/supreme_vase.jpg', 'name' => 'Supreme Bonsai Pot', 'price' => '40€'], ['img' => 'img/gloves_tool.jpg', 'name' => 'Blue Garden Gloves', 'price' => '9€'], ['img' => 'img/pondlilies_outdoor.jpg', 'name' => 'Pond White Lilies', 'price' => '40€']], 'reviews' => [['name' => 'Frederique Cousteau', 'img' => 'img/frederique_cousteau.jpg', 'date' => '2 days ago', 'review' => 4, 'description' => "This is a bonsai alright, but the premium bit makes me twitch my nose. It's not that high quality, but good for beginners."], ['name' => 'Josh Miller', 'img' => 'img/josh_miller.jpg', 'date' => '2 days ago', 'review' => 3, 'description' => "I like this bonsai, but this is expensive! I'll never pay off my student loans at this rate... #stayoffwifiwhenhigh"], ['name' => 'Kelly Mahagan', 'img' => 'img/kelly_mahagan.jpg', 'date' => '2 days ago', 'review' => 5, 'description' => " OMG, this bonsai is so F.A.B.U.L.O.U.S.! My dad thought this was a scam, but i totally convinced him to buy it and I couldn't love this more. Love you too daddy xoxo"]]]);
    }
}