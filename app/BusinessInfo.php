<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusinessInfo extends Model
{
    protected $table = 'vendor_business';

    protected $fillable = [
        'company_name',	'business_website',	'business_address',	'business_phone', 'business_type',	'business_desc', 'business_logo', 'user_id'
    ];
}
