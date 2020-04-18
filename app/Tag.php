<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'tag';
    public $timestamps  = false;
    
    public function products()
    {
        return $this->belongsToMany('App\Product', 'product_tag','id_tag', 'id_product');
    }
}
