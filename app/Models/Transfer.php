<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    protected $table = 'transfers';
    protected $guarded=['id'];

    public function from(){
        return $this->belongsTo('App\Models\User','from','id');
    }

    public function to(){
        return $this->belongsTo('App\Models\User','to','id');
    }
}
