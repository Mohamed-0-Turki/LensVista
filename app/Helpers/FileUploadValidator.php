<?php

namespace Helpers;

final class FileUploadValidator
{
    private function __construct() {}
    public final static function validateExtension(string $fileName, array $allowedExtensions) : bool {
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        if (empty($fileName)) {
            return false;
        } else {
            if (!in_array($fileExtension, $allowedExtensions)) {
                return false;
            }
            return true;
        }
    }
    public final static function validateSize(int $fileSize, int $maxSize = 41943040) : bool {
        if ($fileSize > $maxSize) {
            return false;
        }
        return true;
    }

    public final static function validateType(string $fileType, array $allowedTypes) : bool {
        if (!in_array($fileType, $allowedTypes)) {
            return false;
        }
        return true;
    }
    public final static function validateErrors(int $errors) : bool {
        if ($errors > 0) {
            return false;
        }
        return true;
    }
    public final static function moveFile(string $from, string $to, string $fileName) : bool {
        if (empty($from)) {
            return false;
        }
        $destination = $to . DIRECTORY_SEPARATOR . $fileName;
        if (!move_uploaded_file($from, $destination)) {
            return false;
        }
        return true;
    }
    public final static function removeFile(string $path, string $fileName) : bool {
        $filePath = $path . DIRECTORY_SEPARATOR . $fileName;
        if (!file_exists($filePath)) {
            return false;
        }
        if (!unlink($filePath)) {
            return false;
        }
        return true;
    }
}