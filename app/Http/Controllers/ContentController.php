<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\file;

class ContentController extends Controller
{
    public function createForm()
    {
        return view('content');
    }

    public function uploadcontent(Request $request)
    {

        $data = new File;

        $data->name = $request->input('name');
        $data->jenis_doc = $request->input('jenis_doc');
        $data->deskripsi = $request->input('deskripsi');

        $data->save();
        return back()
            ->with('success', 'File has been uploaded.');
    }


}
