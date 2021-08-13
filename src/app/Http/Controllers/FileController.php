<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File as newFile;

class FileController extends Controller
{
    public function list(Request $request)
    {
        $perPage = 10;
        $page = preg_replace("/[^0-9]/", "", $request->input('page') ?? 1);
        $page = intval($page);

        if ($page < 1) {
            $page = 1;
        }
        $File = new File();
        $result = $File->getList($perPage);
        if(!empty($result['data'])){
            $result['data'] = $this->prepareOutput($result['data']);
        }

        $countPage = ceil($File->count() / $perPage);
        $countPage = intval($countPage);

        return \view('main', [
            'result' => $result,
            'countPage' => $countPage,
            'page' => $page,
        ]);
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

    private function prepareOutput($data)
    {
        $result =[];
        foreach ($data as $file){
            $path_part = pathinfo($file['path']);
            $dateTime = new \DateTime($file['created_at']);
            $file['created_at'] = $dateTime->format('d-m-Y H:i:s');
            $file['name'] = $path_part['basename'];
            $result[] = $file;
        }
        return $result;
    }

    public function download(Request $request)
    {
        $path = $request->input("path") ?? "";
        if (!file_exists(storage_path('app/public') . "/" . $path)) {
            return redirect()->route('home');
        }

        return response()->download(storage_path('app/public') . "/" . $path);
    }
}
