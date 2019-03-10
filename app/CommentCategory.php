<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommentCategory extends Model
{
    public $table='comments_category';
    protected $fillable = ['author','content','category_id'];

}
