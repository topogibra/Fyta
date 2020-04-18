<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRemoval extends Model
{
    protected $table = 'user_removal';
    
    const CREATED_AT = 'sent_date';
}
