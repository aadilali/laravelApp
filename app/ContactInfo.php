<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactInfo extends Model
{
    protected $table = 'vendor_contact';

    protected $fillable = [
        'contact_name',	'contact_email', 'contact_phone', 'contact_position', 'user_id'
    ];
}
