<?php

namespace App\Http\Controllers;

use App\ActivityUser;
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
                if (auth()->user()->id != $user->id) {
                    $result .= '<a href="' . route('profile.delete', $user->id) . '" class="btn btn-outline-danger btn-sm"><i class="fa fa-trash"></i></a> &nbsp';
                }
                $result .= '<a href="' . route('profile.logActivity', $user->id) . '" class="btn btn-outline-info btn-sm"><i class="fa fa-info"></i></a>';
                return $result;
            })
            ->make(true);
    }

    public function getTrash(){
        $user = user::onlyTrashed();
        return DataTables::of($user)
            ->editColumn('created_at', function ($file){
                return Carbon::parse($file->created_at,'Asia/Jakarta')->format('d-m-Y');
            })
            ->addColumn('action', function ($user) {
                $result = '';
                $result .= '<a href="' . route('profile.restore', $user->id) . '" class="btn btn-success btn-sm"><i class="fa fa-trash-restore"></i></a>';
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

    public function logActivity($id){

        \UserActivity::logActivityLists($id);
        return view('ActivityUser',compact('id'));
    }

    public function getActivity($id)
    {
        $documents = ActivityUser::with('users')->select('id','user_id', 'activity','description', 'created_at')->where('user_id',$id);

        return DataTables::of($documents)
            ->editColumn('created_at', function ($documents){
                return Carbon::parse($documents->created_at,'Asia/Jakarta')->format('d-m-Y');
            })
            ->make(true);
    }
}
