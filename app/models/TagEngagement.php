<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class TagEngagement extends Model
{
    protected $table = 'tag_engagements';

    protected $fillable = ['user_id', 'tag_id', 'follow'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
    public function tag()
    {
        return $this->belongsTo('App\Tag');
    }
}
