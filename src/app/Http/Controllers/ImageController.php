<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function store(Request $request)
    {

        // Определение проекта из заголовка
        $projectHeaderValue = $request->header('Project');

        // Назначение пути до целевой папки в бакете, в соответствии с именем бакета
        $path = $request->file('image')->store($projectHeaderValue, 'yandex');

        // Запись в бакет с публичными правами
        Storage::disk('yandex')->setVisibility($path, 'public');

        // Возврат хэша файла для записи в БД
        return basename($path);
    }


    // public function delete(Request $request, $param)
    // {
    //     Image::where('project_id', $request->bearerToken())
    //         ->where('tagable_id', $param)
    //         ->delete();
    // }
}
