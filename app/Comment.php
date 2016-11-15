<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    protected $fillable = [

      'post_id',
      'is_active',
      'author',
      'email',
      'baody',
    ];

    
//    public function post() 
//    {
//      return belongsTo('App\Post');
//    }

    public function replies()
    {
      return $this->hasMany('App\CommentReply');
    }

}
