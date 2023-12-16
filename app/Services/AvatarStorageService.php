<?php

namespace App\Services;

use App\Services\Contracts\FileStorageServiceContract;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AvatarStorageService extends FileStorageService
{
    protected static function getContent(UploadedFile $file): array
    {
        $path = $file->getRealPath();
        $extension = $file->getClientOriginalExtension();
        $config = config('custom.user.avatar.file');

        \Tinify\setKey(env('TINIFY_API_KEY'));
        if ($extension !== $config['ext']) {
        //     $source = \Tinify\fromFile($path);
        //     $converted = $source->convert(array("type" => "image/jpeg"));
        //     $extension = $converted->result()->extension();
        //     if ($extension !== $config['ext']) throw new Exception("Failed to convert avatar file to format {$config['ext']}");
        //     unlink($path);
        //     $path .= '.' . $extension;
        //     $converted->toFile($path);
        }
        $source = \Tinify\fromFile($path);
        $resized = $source->resize(array(
            "method" => "fit",
            "width" => $config['width'],
            "height" => $config['height']
        ));
        unlink($path);
        $resized->toFile($path);

        return array(File::get($path), $extension);
    }
}
