<?php

namespace App\Http\Controllers;

use App\ActivityUser;
use App\Http\Requests\UpdatePasswordRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $activityuser = new ActivityUser();
        $activityuser->user_id = Auth::user()->id;
        $activityuser->activity = "User Melakukan Login";
        $activityuser->description = "Berhasil";
        $activityuser->save();
        return view('home');
    }

    public function edit($id){
        $user = User::findOrFail($id);
        return view('editProfile', compact('user'), [
            'user' => $user
        ]);
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required'
        ]);

        if ($validator->fails()){
            return redirect()->route('home');
        }

        $user = user::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        $activityuser = new ActivityUser();
        $activityuser->user_id = Auth::user()->id;
        $activityuser->activity = 'User Melakukan Update Profile';
        $activityuser->description = "Berhasil";
        $activityuser->save();

        return redirect('home');
    }

    public function editPassword(){
        return view('editPassword');
    }

    public function updatePassword(UpdatePasswordRequest $request){

        $request->user()->update([
            'password' => Hash::make($request->get('password'))
        ]);

        $activityuser = new ActivityUser();
        $activityuser->user_id = Auth::user()->id;
        $activityuser->activity = 'User Melakukan Update Password';
        $activityuser->description = " Berhasil ";
        $activityuser->save();
        return redirect('editProfile');
    }




}
