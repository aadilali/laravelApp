<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventBooking extends Model
{
    protected $table = 'booked_events';

    protected $fillable = [
        'book_date', 'participants', 'user_id', 'event_ids'
    ];
}
