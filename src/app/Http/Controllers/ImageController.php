<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function store(Request $request)
    {

        $projectHeaderValue = $request->header('Project');

        if ($projectHeaderValue === 'zov') {
            $path = $request->file('image')->store('test', 'yandex');
        }

        Storage::disk('yandex')->setVisibility($path, 'public');

        return basename($path);
    }


    // public function store(Request $request)
    // {

    //     $file = $request->file('image');
    //     $projectHeaderValue = $request->header('Project');

    //     $filePath = $file->getClientOriginalName();
    //     // dd($filePath);
    //     // Использование диска 'yandex'
    //     Storage::disk('yandex')->put($filePath, file_get_contents($file));



    //     return basename($filePath);
    // }

    // public function store(Request $request)
    // {

    //     $projectHeaderValue = $request->header('Project');

    //     if ($projectHeaderValue === 'zov') {
    //         $path = $request->file('image')->store('zov', 's3');
    //     }

    //     Storage::disk('s3')->setVisibility($path, 'public');

    //     return basename($path);
    // }

    public function delete(Request $request, $param)
    {
        Image::where('project_id', $request->bearerToken())
            ->where('tagable_id', $param)
            ->delete();
    }
}
