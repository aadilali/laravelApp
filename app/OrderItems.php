<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Orders;

class OrderItems extends Model
{
    protected $table = 'order_items';

    protected $fillable = [
        'event_id', 'unit_price', 'order_id'
    ];

    public function order()
    {
        return $this->belongsTo('App\Orders');
    }
}
