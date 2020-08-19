<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\file;

class UploadController extends Controller
{
    public function createForm(){
        return view('upload');
    }

    public function uploadFile(Request $req){
        $req->validate([
        'file' => 'required|mimes:csv,txt,xlx,xls,pdf|max:2048'
        ]);

        $fileModel = new file;

        if($req->file()) {
            $fileName = time().'_'.$req->file->getClientOriginalName();
            $filePath = $req->file('file')->storeAs('uploads', $fileName, 'public');

            $fileModel->jenis_doc = $req->input('jenis_doc');
            $fileModel->name = time().'_'.$req->file->getClientOriginalName();
            $fileModel->file_path = $filePath;
            $fileModel->save();

            return back()
            ->with('success','File has been uploaded.')
            ->with('file', $fileName);
        }
    }
}
