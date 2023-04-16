<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Drill extends Model
{
    protected $fillable = ['title', 'category_name'];

    //ログインユーザのみ操作可能にするための処理
    public function user()
    {
        return $this->belongsTo('App\User');
    }

}


