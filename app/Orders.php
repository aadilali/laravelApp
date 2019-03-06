<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\OrderItems;

class Orders extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'order_id', 'event_date', 'participants', 'event_time', 'zip_code',	'event_notes', 'sub_total',	'customer_id', 'cart_details'
    ];

    /**
     * Get the order items for the order.
     */
    public function orderItems()
    {
        return $this->hasMany('App\OrderItems', 'order_id');
    }
}
