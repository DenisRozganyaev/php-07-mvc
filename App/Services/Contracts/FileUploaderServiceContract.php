<?php

namespace App\Services\Contracts;

interface FileUploaderServiceContract
{
    public static function upload(array $file, string $uploadDir = IMG_DIR): string|bool;

    public static function remove(string $path);
}