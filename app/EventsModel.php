<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventsModel extends Model
{
    //
    protected $table = 'events_post';

    protected $fillable = [
        'title', 'desc', 'author_id', 'product_category', 'is_featured', 'price',  'product_type', 'product_quantity', 'availablity', 'setup_time', 'product_options', 'product_includes', 'product_logistics', 'product_fine_print', 'image_url'
    ];

}
