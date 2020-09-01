<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QueryPrice extends Model
{
    //
    protected $fillable = [
        'query_tracker_id', 'price_analytics'
    ];
}
