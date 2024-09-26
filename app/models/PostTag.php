<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class PostTag extends Model
{
    protected $table = "post_tag";
    protected $fillable = ['post_id', 'tag_id'];
}
