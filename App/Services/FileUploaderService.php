<?php

namespace App\Services;

use App\Services\Contracts\FileUploaderServiceContract;

class FileUploaderService implements FileUploaderServiceContract
{

    /**
     * @param array $file
     * @param string $uploadDir = IMG_DIR (ABS_PATH/public/assets/images)
     * @return string|bool
     */
    public static function upload(array $file, string $uploadDir = IMG_DIR): string|bool
    {
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0775, true);
        }

        $uploadFile = $uploadDir . '/' . time() . '_' . basename($file['name']);
        move_uploaded_file($file['tmp_name'], $uploadFile);

        return str_replace(IMG_DIR, '', $uploadFile);
    }

    public static function remove(string $path) {}
}
