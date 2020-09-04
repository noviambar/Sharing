<?php

namespace App\Http\Controllers;

use App\ActivityUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(){
        return view ('register');
    }

    public function postRegister(Request $request){

        $data = new User();
        $data->name = $request->input('name');
        $data->email = $request->input('email');
        $data->role = $request->input('role');
        $data->password = Hash::make($request->input('password'));
        $data->save();

        $activityuser = new ActivityUser();
        $activityuser->user_id = Auth::user()->id;
        $activityuser->activity = 'Menambahkan Data Karyawan';
        $activityuser->save();
        return view('profile');
    }
}
