<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        return view('profile');
    }
}
