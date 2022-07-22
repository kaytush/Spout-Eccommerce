<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    protected $table = 'deposits';
    protected $guarded=['id'];

    public function user(){
        return $this->belongsTo('App\Models\User','user_id','id');
    }
}
