<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = "messenger";

    public function sender(){
        return $this->belongsTo('App\User','sender_id');
    }

    public function recipient(){
        return $this->belongsTo('App\User', 'receiver_id');
    }
    //
}
