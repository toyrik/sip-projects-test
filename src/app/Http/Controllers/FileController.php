<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File as newFile;

class FileController extends Controller
{
    public function list()
    {
        return \view('main');
    }

    public function upload(Request $request)
    {
        if($request->hasFile('file-name')) {
            $Entity = new File();
            $file = $request->file('file-name');
            $nameFile = time().$file->getClientOriginalName();
            Storage::disk('public')->put($nameFile, newFile::get($file));
            $path = Storage::disk('public')->url($nameFile);
            $Entity->path = $path;
            $Entity->size = round($file->getSize()/1024, 2). "KB";
            $Entity->save();
        }
        return redirect()->route('home');
    }
}
