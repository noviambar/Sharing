<?php

namespace App\Http\Controllers;

use App\ActivityUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(){

        $activityuser = new ActivityUser();
        $activityuser->user_id = Auth::user()->id;
        $activityuser->activity = "User Melakukan Login";
        $activityuser->description = "Berhasil";
        $activityuser->save();

        return view ('login.login');
    }
}
