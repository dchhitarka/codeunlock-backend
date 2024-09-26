<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class PostEngagement extends Model
{
    protected $table = 'post_engagements';

    protected $fillable = ['user_id', 'post_id', 'like', 'bookmark'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
    public function post()
    {
        return $this->belongsTo('App\Post');
    }
}
