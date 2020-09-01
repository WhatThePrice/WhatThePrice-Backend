<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QueryTracker extends Model
{
    //
    protected $fillable = [
        'query', 'user_id', 'track_status'
    ];
}
