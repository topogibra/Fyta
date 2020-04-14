<?php

namespace App;

use App\Discount;

class DiscountCode extends Discount
{
    protected $table = 'discount_code';
    public $timestamps  = false;
}
