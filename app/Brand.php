<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = [
        'cat_id', 'name', 'status'
    ];
    function cat()
    {
        return $this->belongsTo('App\Cat');
    }
    function product()
    {
        return $this->hasMany('App\Product');
    }
}
