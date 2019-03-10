<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommentPost extends Model
{
    protected $fillable = ['author','content','post_id'];
}
