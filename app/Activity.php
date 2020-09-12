<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\File;

class Activity extends Model
{
    protected $fillable = [
        'title', 'user_id','name','file_id','activity'
    ];

    public function document(){
        return $this->belongsTo(\App\File::class);
    }

}
