<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductTracker extends Model
{
    //
    protected $fillable = [
        'product_url', 'user_id', 'track_status', 'product_name'
    ];
}
