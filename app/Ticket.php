<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    public $timestamps  = false;

    public function user()
    {
        return $this->belongsTo('App\User', 'id_user');
    }

    public function messages()
    {
        return $this->hasMany('App\TicketMessage', 'id_ticket');
    }

    public function history()
    {
        return $this->hasMany('App\TicketHistory', 'id_ticket');
    }
}
