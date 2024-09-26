<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';

    /**
     * Give the one to one relationship with User
     */ 
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function comments()
    {
        return $this->hasMany("App\models\Comment")->orderBy('created_at', "desc");
    }

    public function post_engagements()
    {
        return $this->hasMany("App\models\PostEngagement")->orderBy('updated_at', "desc")->select(array('user_id', 'like', 'bookmark'));
    }

    public function tags()
    {
        return $this->belongsToMany('App\models\Tag')->select(array('tag', 'tag_slug'));
    }

}
