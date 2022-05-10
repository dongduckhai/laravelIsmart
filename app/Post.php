<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'title', 'desc', 'cat_id', 'content', 'thumbnail','status','hot'
    ];
    function cat()
    {
        return $this->belongsTo('App\Cat');
    }
}
