<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductPrice extends Model
{
    //
    protected $fillable = [
        'product_tracker_id', 'price'
    ];
}
