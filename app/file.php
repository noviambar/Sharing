<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class file extends Model
{
    protected $fillable = [
        'name',
        'jenis_doc',
        'deskripsi',
        'file_path'
    ];
}
