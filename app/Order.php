<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name', 'phone', 'email', 'address','note',
        'total','payment', 'status', 'code', 'qty'
    ];
    function product()
    {
        return $this->belongsToMany('App\Product','order_details')->withPivot('qty');
    }
}
