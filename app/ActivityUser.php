<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActivityUser extends Model
{
    protected $fillable = [
        'user_id', 'activity','description'
    ];

    public function users(){
        return $this->belongsTo(\App\User::class);
    }
}
