<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    // public function store(Request $request)
    // {

    //     // Определение проекта из заголовка
    //     $projectHeaderValue = $request->header('Project');

    //     // Назначение пути до целевой папки в бакете, в соответствии с именем бакета
    //     $path = $request->file('image')->store($projectHeaderValue, 'yandex');

    //     // Запись в бакет с публичными правами
    //     Storage::disk('yandex')->setVisibility($path, 'public');

    //     // Возврат хэша файла для записи в БД
    //     return basename($path);
    // }


    public function store(Request $request)
    {
        // Проверка наличия файла 'image' и заголовка 'Project'
        if (!$request->hasFile('image') || !$request->header('Project')) {
            // Возвращаем ошибку, если что-то отсутствует
            return response()->json(['error' => 'Необходим файл и заголовок Project'], 400);
        }

        try {
            // Определение проекта из заголовка
            $projectHeaderValue = $request->header('Project');

            // Назначение пути до целевой папки в бакете
            $path = $request->file('image')->store($projectHeaderValue, config('filesystems.default'));

            // Запись в бакет с публичными правами
            Storage::disk(config('filesystems.default'))->setVisibility($path, 'public');

            // Возврат хэша файла для записи в БД
            return basename($path);
        } catch (\Exception $e) {
            // Обработка исключений, например, проблем с хранилищем
            return response()->json(['error' => 'Ошибка при сохранении файла'], 500);
        }
    }
}
