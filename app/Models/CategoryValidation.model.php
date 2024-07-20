<?php

namespace Models;

use Core\Database;
use Core\Model;
use Helpers\FileUploadValidator;
use Helpers\StringValidator;

class CategoryValidation
{
    public function validateCategoryID(string|int $id): array {
        $errors = [];
        $result = Model::table('categories')->select('category_ID')->where('category_ID', $id)->get();
        if (empty($result)) {
            $errors[] = "Invalid category ID: $id.";
        }
        return $errors;
    }

    public function validateCategoryName(string $name = ''): array
    {
        $errors = [];
        if (!StringValidator::isLengthValid($name, 3, 20)) {
            $errors[] = 'Category name must be between 3 and 20 characters.';
        }
        return $errors;
    }

    public function checkCategoryNameExists(string $name = ''): bool
    {
        $query = "SELECT `name` FROM `categories` WHERE `name` = :name";
        $data = Database::executeQuery($query, [':name' => $name]);
        if (count($data) != 0) {
            return true;
        }
        return false;
    }

    public function isCategoryNameTaken(string $name = '', string $categoryID = ''): bool
    {
        $fields = [
            ':name' => $name,
            ':categoryID' => $categoryID
        ];
        $query = "SELECT `name` FROM `categories` WHERE `name` = :name AND `category_ID` != :categoryID;";
        $result = Database::executeQuery($query, $fields);
        if (count($result) > 0) {
            return true;
        }
        return false;
    }

    public function validateCategoryDescription(string $description = ''): array
    {
        $errors = [];
        if (!StringValidator::isLengthValid($description, 3, 200)) {
            $errors[] = 'Category description must be between 3 and 200 characters.';
        }
        return $errors;
    }

    public function validateCategoryImage(array $file = []): array
    {
        $errors = [];
        if (! FileUploadValidator::validateExtension($file['name'], ['jpeg', 'jpg', 'png'])) {
            $errors[] = 'Invalid file extension.';
        }
        elseif (! FileUploadValidator::validateType($file['type'], ['image/jpeg', 'image/png', 'image/jpg'])) {
            $errors[] = 'Invalid file type.';
        }
        elseif (! FileUploadValidator::validateErrors($file['error'])) {
            $errors = 'File upload error';
        }
        elseif (! FileUploadValidator::validateSize($file['size'], 5242880)) {
            $errors[] = 'File size must be less than 5MB.';
        }
        return $errors;
    }
}