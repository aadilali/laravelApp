<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventsModel extends Model
{
    //
    protected $table = 'events_post';

    protected $fillable = [
        'title', 'desc', 'author_id', 'category', 'is_featured', 'price', 'image_url'
    ];

}
