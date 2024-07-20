<?php

namespace Helpers;

final class FormInputHandler
{
    private function __construct(){}
    public final static function getPostVariable(string $key) : string {
        if (isset($_POST[$key])) {
            return $_POST[$key];
        }
        return '';
    }
    public final static function getSelectedStatus(string $key, string $value) : string {
        if (isset($_POST[$key])) {
            if ($_POST[$key] == $value)
                return 'selected';
            return '';
        }
        return '';
    }
    public final static function getCheckedStatus(string $key, string $value) : string {
        if (isset($_POST[$key])) {
            if ($_POST[$key] == $value)
                return 'checked';
            return '';
        }
        return '';
    }
    public final static function sanitizeInput($values) : string | array {
        if (is_array($values)) {
            foreach ($values as $key => $value) {
                $values[$key] = self::sanitizeInput($value);
            }
            return $values;
        }
        $values = trim($values);
        $values = stripslashes($values);
        $values = strip_tags($values);
        return htmlspecialchars($values);
    }
    public final static function arePostKeysPresent(array $requiredKeys) : bool
    {
        foreach ($requiredKeys as $key) {
            if (!isset($_POST[$key])) {
                return false;
            }
        }
        return true;
    }
    public final static function areFileKeysPresent(array $requiredKeys) : bool
    {
        foreach ($requiredKeys as $key) {
            if (!isset($_FILES[$key])) {
                return false;
            }
        }
        return true;
    }
}