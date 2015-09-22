<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Userservice extends Model
{

    public $guarded = ['id'];
    public $timestamps = false;

    public function user(){
        return $this->belongsTo('App\User');
    }
}
