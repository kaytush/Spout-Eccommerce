<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConvertAirtimeLog extends Model
{
    protected $table = 'convert_airtime_log';
    protected $guarded=[];

    public function provider(){
        return $this->belongsTo('App\Models\ConvertAirtime','p_id','id');
    }

    public function p(){
        return $this->belongsTo('App\Models\ConvertAirtime','p_id','id');
    }
}
