<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActivityUser extends Model
{
    protected $fillable = [
        'user_id', 'activity',
    ];

    public function users(){
        return $this->belongsTo(\App\User::class);
    }
}
