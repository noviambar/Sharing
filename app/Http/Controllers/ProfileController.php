<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class ProfileController extends Controller
{
    public function profile(){
        return view('profile');
    }

    public function getProfile(){
        $user = user::select('name','email','role','created_at');
        return DataTables::of($user)->make(true);
    }
}
