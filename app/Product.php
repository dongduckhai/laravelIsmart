<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'images', 'price', 'old_price', 'name', 'desc',
         'details', 'brand_id', 'cat_id', 'status', 'hot'
    ];
    function brand()
    {
        return $this->belongsTo('App\Brand');
    }
    function cat()
    {
        return $this->belongsTo('App\Cat');
    }
    function order()
    {
        return $this->belongsToMany('App\Order','order_details')->withPivot('qty');
    }
}
