<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $guarded = ['id','created_at','updated_at'];
    public $dates = ['paid_at'];

    public function user(){
        return $this->belongsTo('App\User');
    }
}
