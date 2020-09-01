<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Queries extends Model
{
    //
    protected $fillable = [
        'query', 'status', 'status_code','user_id','result_length','query_time'
    ];
}
