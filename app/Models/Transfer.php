<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    protected $table = 'transfers';
    protected $guarded=['id'];

    public function sent_from(){
        return $this->belongsTo('App\Models\User','from','id');
    }

    public function sent_to(){
        return $this->belongsTo('App\Models\User','to','id');
    }

    public function trans(){
        return $this->belongsTo('App\Models\Transaction','trx','trx');
    }
}
