<?php

namespace App\Http\Controllers;

use App\Activity;
use App\ActivityUser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\file;
use DataTables;
use Alert;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class TrainingController extends Controller
{
    public function training(){
        $documents = File::with('user')->get();

        return view('training',['files' => $documents]);
    }

    public function getTraining(){
        $file = File::with('user')->select('id','user_id', 'title', 'jenis_doc', 'file_path', 'created_at')->where('jenis_doc','training');
        return DataTables::of($file)
            ->editColumn('created_at', function ($file){
                return Carbon::parse($file->created_at,'Asia/Jakarta')->format('d-m-Y');
            })
            ->addColumn('action', function($file) {
                $result = '';
                $result .= '<a href="'.route('training.show', $file->id).'" class="btn btn-outline-success btn-sm"><i class="fa fa-search"></i></a> &nbsp';
                $result .= '<a href="'.route('training.edit', $file->id).'" class="btn btn-outline-primary btn-sm"><i class="fa fa-edit"></i></a> &nbsp';
                if (auth()->user()->role == 'admin'){
                    $result .= '<a href="' . route('logActivity', $file->id) . '" class="btn btn-outline-info btn-sm"><i class="fa fa-info"></i></a> &nbsp';
                }
                $result .= '<a target="_blank" href="'.asset(Storage::url($file->file_path)).'" class="btn btn-outline-secondary btn-sm"><i class="fa fa-file"></i></a> &nbsp';
                return $result;
            })
            ->make(true);

    }

    public function edit($id){
        $file = File::findOrFail($id);
        return view('editTraining', compact('file'), [
            'file' => $file
        ]);
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'jenis_doc' => 'required',
            'file' => 'mimes:csv,txt,xlx,xls,pdf|max:2048',
            'deskripsi' => 'required',
            'title' => 'required'
        ]);

        if($validator->fails()){
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $file = File::findOrFail($id);
        if($request->hasFile('file')){
            $fileName = time() . '_' . $request->file->getClientOriginalName();
            $filePath = $request->file('file')->storeAs('uploads', $fileName, 'public');

            $file->file_path = $filePath;
            $file->namaFile = $fileName;
        }
        $file->jenis_doc = $request->jenis_doc;
        $file->title = $request->title;
        $file->deskripsi = $request->deskripsi;

        $file->save();

        $activity = new Activity();
        $activity->title = $request->title;
        $activity->user_id = Auth::user()->id;
        $activity->name = Auth::user()->name;
        $activity->file_id = $file->id;
        $activity->save();

        $activityuser = new ActivityUser();
        $activityuser->user_id = Auth::user()->id;
        $activityuser->activity = 'User telah melakukan Update Data Training';
        $activityuser->description = $file->title;
        $activityuser->save();

        return redirect('training');

    }

    public function download($id)
    {
        $file = File::findOrFail($id);
        return Storage::disk('public')->download($file->file_path);
    }

    public function show($id)
    {
        $file = File::findOrFail($id);
        return view('showTraining', compact('file'), [
            'file' => $file
        ]);
    }

    public function logActivity($id){

        \LogActivity::logActivityLists($id);
        return view('logActivity',compact('id'));
    }

    public function getActivity($id)
    {
        $documents = Activity::with('document')->select('id','name','file_id','user_id', 'title', 'created_at')->where('file_id', $id);

        return DataTables::of($documents)
            ->editColumn('created_at', function ($documents){
                return Carbon::parse($documents->created_at,'Asia/Jakarta')->format('d-m-Y');
            })
            ->make(true);
    }

    public function getTrash(){
        $file = File::with('user')->onlyTrashed();
        return DataTables::of($file)
            ->editColumn('created_at', function ($documents){
                return Carbon::parse($documents->created_at,'Asia/Jakarta')->format('d-m-Y');
            })
            ->addColumn('action', function ($file) {
                $result = '';
                $result .= '<a href="' . route('training.restore', $file->id) . '" class="btn btn-success btn-sm"><i class="fa fa-trash-restore"></i></a>';
                return $result;
            })
            ->make(true);
    }

    public function delete($id)
    {
        $file = File::find($id);
        $file->delete();

        $activity = new Activity();
        $activity->title = $file->title;
        $activity->user_id = Auth::user()->id;
        $activity->name = Auth::user()->name;
        $activity->file_id = $file->id;
        $activity->activity = 'File telah di hapus';
        $activity->save();

        $activityuser = new ActivityUser();
        $activityuser->user_id = Auth::user()->id;
        $activityuser->activity = "User Menghapus File";
        $activityuser->description = $file->title;
        $activityuser->save();
        return view('training');
    }

    public function trashtraining(){
        $file = File::onlyTrashed()->get();
        return view('trashTraining',['files' => $file]);
    }

    public function restore($id){
        $file = File::withTrashed()->where('id',$id)->first();
        $file->restore();

        $activity = new Activity();
        $activity->title = $file->title;
        $activity->user_id = Auth::user()->id;
        $activity->name = Auth::user()->name;
        $activity->file_id = $id;
        $activity->activity = 'File telah di restore';
        $activity->save();

        $activityuser = new ActivityUser();
        $activityuser->user_id = Auth::user()->id;
        $activityuser->activity = "User Mengembalikan File";
        $activityuser->description = $file->title;
        $activityuser->save();
        return view('training');
    }
}
