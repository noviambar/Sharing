<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\file;
use DataTables;
use App\Activity;
use Illuminate\Support\Facades\Auth;
use UxWeb\SweetAlert\SweetAlert;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class MeetingController extends Controller
{
    public function meeting()
    {
        $documents = File::with('user')->get();

        return view('meeting', ['files' => $documents]);
    }

    public function getMeeting()
    {
        $file = File::with('user')->select('id','user_id', 'title', 'jenis_doc', 'file_path', 'created_at')->where('jenis_doc', 'meeting');
        return DataTables::of($file)
            ->editColumn('created_at', function ($file){
                return Carbon::parse($file->created_at,'Asia/Jakarta')->format('d-m-Y');
            })
            ->addColumn('action', function ($file) {
                $result = '';
                $result .= '<a href="' . route('meeting.show', $file->id) . '" class="btn btn-outline-success btn-sm"><i class="fa fa-search"></i></a> &nbsp';
                $result .= '<a href="' . route('meeting.edit', $file->id) . '" class="btn btn-outline-primary btn-sm"><i class="fa fa-edit"></i></a> &nbsp';
                $result .= '<a href="' . route('logActivity', $file->id) . '" class="btn btn-outline-info btn-sm"><i class="fa fa-info"></i></a> &nbsp';
                $result .= '<a target="_blank" href="'.asset(Storage::url($file->file_path)).'" class="btn btn-outline-secondary btn-sm"><i class="fa fa-file"></i></a> &nbsp';
                return $result;
            })
            ->make(true);

    }

    public function edit($id)
    {
        $file = File::findOrFail($id);
        return view('edit', compact('file'), [
            'File' => $file
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'jenis_doc' => 'required',
            'file' => 'mimes:csv,txt,xlx,xls,pdf|max:2048',
            'deskripsi' => 'required'
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
        }
        $file->jenis_doc = $request->jenis_doc;
        $file->title = $request->title;
        $file->deskripsi = $request->deskripsi;


        $file->save();

        $activity = new Activity();
        $activity->title = $request->title;
        $activity->user_id = Auth::user()->id;
        $activity->name = Auth::user()->name;
        $activity->save();
        return redirect('meeting');

    }

    public function delete($id)
    {
        DB::table('files')->where('id', $id)->delete();

        return redirect('meeting');
    }

    public function destroy($id)
    {
        $file = File::findOrFail($id);
        $file->delete();
        return redirect('meeting')->with('success', 'File has been Delete');
    }

    public function show($id)
    {
        $file = File::findOrFail($id);
        return view('show', compact('file'), [
            'file' => $file
        ]);
    }

    public function logActivity(){
        \LogActivity::logActivityLists();
        return view('logActivity');
    }

    public function getActivity()
    {
        $file = Activity::select('id','name','user_id', 'title', 'created_at');

        return DataTables::of($file)
            ->editColumn('created_at', function ($file){
                return Carbon::parse($file->created_at,'Asia/Jakarta')->format('d-m-Y');
            })
            ->make(true);
    }

}
