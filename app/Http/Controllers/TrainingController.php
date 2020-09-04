<?php

namespace App\Http\Controllers;

use App\Activity;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\file;
use DataTables;
use Alert;
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
                $result .= '<a href="' . route('logActivity', $file->id) . '" class="btn btn-outline-info btn-sm"><i class="fa fa-info"></i></a> &nbsp';
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
            'file' => 'required|mimes:csv,txt,xlx,xls,pdf|max:2048'
        ]);

        $file = File::findOrFail($id);
        if($request->hasFile('file')){
            $fileName = time() . '_' . $request->file->getClientOriginalName();
            $filePath = $request->file('file')->storeAs('uploads', $fileName, 'public');

            $file->name = time() . '_' . $request->file->getClientOriginalName();
            $file->file_path = $filePath;
        }
        $file->jenis_doc = $request->jenis_doc;
        $file->title = $request->title;
        $file->deskripsi = $request->deskripsi;

        $file->save();
        Alert::success('Messsage', 'Optional Title');
        return back()->with('status', 'File has been Update');

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

        return view('training');
    }

    public function trashtraining(){
        $file = File::onlyTrashed()->get();
        return view('trashTraining',['files' => $file]);
    }

    public function restore($id){
        $file = File::onlyTrashed()->where('id',$id);
        $file->restore();
        return view('training');
    }
}
