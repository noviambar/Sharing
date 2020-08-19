<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\file;
use DataTables;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class MeetingController extends Controller
{
    public function meeting()
    {
        $documents = file::all();

        return view('meeting', ['files' => $documents]);
    }

    public function getMeeting()
    {
        $file = file::select('id', 'name', 'jenis_doc', 'file_path', 'created_at')->where('jenis_doc', 'meeting');
        return DataTables::of($file)
            ->addColumn('action', function ($file) {
                $result = '';
                $result .= '<a href="' . route('meeting.show', $file->id) . '" class="btn btn-success btn-sm"><i class="fa fa-search"></i></a>';
                $result .= '<a href="' . route('meeting.edit', $file->id) . '" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>';
                $result .= '<a href="' . route('meeting.delete', $file->id) . '" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>';
                return $result;
            })
            ->make(true);

    }

    public function edit($id)
    {
        $file = file::findOrFail($id);
        return view('edit', compact('file'), [
            'file' => $file
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'jenis_doc' => 'required',
            'file' => 'mimes:csv,txt,xlx,xls,pdf|max:2048'
        ]);

        $file = file::findOrFail($id);
        if($request->hasFile('file')){
            $fileName = time() . '_' . $request->file->getClientOriginalName();
            $filePath = $request->file('file')->storeAs('uploads', $fileName, 'public');

            $file->name = time() . '_' . $request->file->getClientOriginalName();
            $file->file_path = $filePath;
        }
        $file->jenis_doc = $request->jenis_doc;
        $file->name = $request->name;
        $file->deskripsi = $request->deskripsi;


        $file->save();

        return back()->with('status', 'File has been Update');

    }

    public function delete($id)
    {
        DB::table('files')->where('id', $id)->delete();
        return back();
    }

    public function destroy($id)
    {
        $file = file::findOrFail($id);
        $file->delete();
        return redirect('meeting')->with('status', 'File has been Delete');
    }

    public function download($id)
    {
        $file = file::findOrFail($id);
        return Storage::disk('public')->download($file->file_path);
    }

    public function show($id)
    {
        $file = file::findOrFail($id);
        return view('show', compact('file'), [
            'file' => $file
        ]);
    }


}
