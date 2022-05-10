<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cat extends Model
{
    protected $fillable = [
        'name','status'
    ];
    function brand()
    {
        return $this->hasMany('App\Brand');
    }
    function post()
    {
        return $this->hasMany('App\Post');
    }
}
