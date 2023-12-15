<?php

namespace App\Services;

use App\Services\Contracts\FileStorageServiceContract;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileStorageService implements FileStorageServiceContract
{
    protected static UploadedFile $file;

    public static function upload(UploadedFile $file, string $additionalPath = ''): string
    {
        self::$file = $file;
        $content = static::getContent();

        $additionalPath = !empty($additionalPath) ? "{$additionalPath}/" : '';

        $filePath = "public/{$additionalPath}" . Str::random() . '_' . time() . '.' . static::getExtension();
        Storage::disk('s3')->put($filePath, $content);
        Storage::setVisibility($filePath, 'public');

        return $filePath;
    }

    public static function remove(string $file): void
    {
        Storage::disk('s3')->delete($file); // ?
    }

    protected static function getContent(): string
    {
        return File::get(self::$file);
    }

    protected static function getExtension(): string
    {
        return self::$file->getClientOriginalExtension();
    }
}
