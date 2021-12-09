<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class MainService
{
    public function saveImage($image, string $folder, int $width, int $height = null, string $filename = null): string
    {
        if (empty($filename)) $filename = Str::random(32) . '.' . $image->getClientOriginalExtension();

        $path = storage_path('app/public/' . $folder);
        File::isDirectory($path) or File::makeDirectory($path, 0775, true, true);

        $path = storage_path('app/public/' . $folder . '/' . $filename);

        if (!empty($height))
            Image::make($image)->fit($width, $height)->save($path);
        else
            Image::make($image)->resize($width, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($path);
        return basename($filename);
    }

    public function saveImageOrDocument($file, string $folder, int $width = 1920, int $height = null, string $filename = null): string
    {
        $extension = $file->getClientOriginalExtension();
        if (empty($filename)) $filename = Str::random(32) . '.' . $extension;

        $path = storage_path('app/public/' . $folder);
        File::isDirectory($path) or File::makeDirectory($path, 0777, true, true);

        $path = storage_path('app/public/' . $folder . '/' . $filename);

        if(in_array($extension, ['jpg','jpeg','png','gif'])) {
            if (!empty($height))
                Image::make($file)->fit($width, $height)->save($path);
            else
                Image::make($file)->resize($width, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($path);
        } else
            Storage::putFileAs('public/' . $folder, $file, $filename);


        return basename($filename);
    }

    public function makePin(): string
    {
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPGRSTUVWXYZ';
        return substr(str_shuffle($permitted_chars), 0, 10);
    }
}
