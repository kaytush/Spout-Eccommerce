<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminLogin extends Model
{
    protected $guarded = [];

    protected $table = "admin_logins";

    public function admin()
    {
        return $this->belongsTo(Admin::class)->withDefault();
    }
}
