<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketMessage extends Model
{
    const CREATED_AT = 'sent_date';

    protected $table = 'ticket_message';

    public function user()
    {
        return $this->belongsTo('App\User', 'id_user');
    }

    public function ticket()
    {
        return $this->belongsTo('App\Ticket', 'id_ticket');
    }
}
