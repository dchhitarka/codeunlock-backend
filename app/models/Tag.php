<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = "tags";
    protected $fillable = ['tag', 'user_id'];

    /**
     * Give the one to one relationship with User
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function posts()
    {
        return $this->belongsToMany('App\models\Post');
    }

    public function tag_engagements()
    {
        return $this->hasMany('App\models\TagEngagement');
    }

}
