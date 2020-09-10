<?php

namespace App\Http\Controllers;

use App\Activity;
use App\ActivityUser;
use Illuminate\Http\Request;
use App\file;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ContentController extends Controller
{
    public function createForm()
    {
        return view('content');
    }

    public function createFormTraining()
    {
        return view('contentTraining');
    }

    public function uploadcontent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'jenis_doc' => 'required',
            'title' => 'required|unique:files,title',
            'deskripsi' => 'required',
            'file' => 'mimes:csv,txt,xlx,xls,pdf,png,jpg,docx|max:2048'
        ]);

        if($validator->fails()){
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        $data = new File;

        if($request->file()) {
            $fileName = time().'_'.$request->file->getClientOriginalName();
            $filePath = $request->file('file')->storeAs('uploads', $fileName, 'public');

            $data->file_path = $filePath;
            $data->namaFile = $fileName;

        }
        $data->user_id = Auth::user()->id;
        $data->title = $request->input('title');
        $data->jenis_doc = $request->input('jenis_doc');
        $data->deskripsi = $request->input('deskripsi');

        $data->save();

        $activity = new Activity();
        $activity->title = $request->input('title');
        $activity->user_id = Auth::user()->id;
        $activity->name = Auth::user()->name;
        $activity->file_id = $data->id;
        $activity->save();

        $activityuser = new ActivityUser();
        $activityuser->user_id = Auth::user()->id;
        $activityuser->activity = 'File Meeting telah dibuat';
        $activityuser->save();
        return redirect('meeting');
    }

    public function uploadtraining(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'jenis_doc' => 'required',
            'title' => 'required',
            'deskripsi' => 'required',
            'file' => 'mimes:csv,txt,xlx,xls,pdf|max:2048'
        ]);

        if($validator->fails()){
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        $data = new File;

        if($request->file()) {
            $fileName = time().'_'.$request->file->getClientOriginalName();
            $filePath = $request->file('file')->storeAs('uploads', $fileName, 'public');

            $data->file_path = $filePath;
            $data->namaFile = $fileName;

        }
        $data->user_id = Auth::user()->id;
        $data->title = $request->input('title');
        $data->jenis_doc = $request->input('jenis_doc');
        $data->deskripsi = $request->input('deskripsi');

        $data->save();

        $activity = new Activity();
        $activity->title = $request->input('title');
        $activity->user_id = Auth::user()->id;
        $activity->name = Auth::user()->name;
        $activity->file_id = $data->id;
        $activity->save();

        $activityuser = new ActivityUser();
        $activityuser->user_id = Auth::user()->id;
        $activityuser->activity = 'File Training telah dibuat';;
        $activityuser->save();
        return redirect('training');
    }


}
