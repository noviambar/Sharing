<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use App\Models\User;

class File extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'jenis_doc',
        'deskripsi',
        'file_path',
        'namaFile'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function history(){
        return $this->hasMany('document', 'file_id','id');
    }

}
