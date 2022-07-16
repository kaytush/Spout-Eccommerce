<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'trxs';
    protected $guarded=[];

    public function user(){
        return $this->belongsTo('App\Models\User','user_id','id');
    }
}
