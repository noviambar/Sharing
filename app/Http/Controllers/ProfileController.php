<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use DataTables;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function profile(){
        $user = User::all();
        return view('profile',['users' => $user]);
    }

    public function getProfile(){
        $user = user::select('id','name','email','role','created_at');
        return DataTables::of($user)
            ->editColumn('created_at', function ($file){
                return Carbon::parse($file->created_at,'Asia/Jakarta')->format('d-m-Y');
            })
            ->addColumn('action', function ($user) {
                $result = '';
                $result .= '<a href="' . route('profile.delete', $user->id) . '" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>';
                return $result;
            })
            ->make(true);
    }

    public function getTrash(){
        $user = user::onlyTrashed();
        return DataTables::of($user)
            ->addColumn('action', function ($user) {
                $result = '';
                $result .= '<a href="' . route('profile.restore', $user->id) . '" class="btn btn-success btn-sm"><i class="fa fa-trash-restore"></i></a>';
                $result .= '<a href="' . route('profile.delete', $user->id) . '" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>';
                return $result;
            })
            ->make(true);
    }

    public function delete($id)
    {
        $user = User::find($id);
        $user->delete();

        return redirect('profile');
    }

    public function trash(){
        $user = User::onlyTrashed()->get();
        return view('trash',['users' => $user]);
    }

    public function restore($id){
        $user = User::onlyTrashed()->where('id',$id);
        $user->restore();
        return redirect('profile');
    }

}
