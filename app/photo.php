<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
  protected $fillable = [
    'file'
  ];

  //画像の参照パスを指定
  protected $uploads = '/images/';

  //画像のパスの指定メソッド これを行うとviewから呼び出す際にパスの指定が不要
  //画像使用場所例：admin.users.invdex.blade.php 
  //　？？これはどこから呼んでいるんだろう
  public function getFileAttribute($photo) {
  
    return $this->uploads .$photo;
  }
  
}
