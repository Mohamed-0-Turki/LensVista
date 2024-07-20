<?php

namespace Helpers;

final class StringValidator
{
    private function __construct(){}

    public static function isEmpty(string $string): bool {
        return trim($string) === '';
    }
    public final static function isValidEmail(string $email) : bool {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }
    public final static function isLengthValid(string $str, int $minLength, int $maxLength) : bool {
        $length = strlen($str);
        return $length >= $minLength && $length <= $maxLength;
    }
    public final static function isAlpha(string $str) : bool {
        return ctype_alpha($str);
    }
    public final static function isAlphanumeric(string $str) : bool {
        return ctype_alnum($str);
    }
    public final static function matchesPattern(string $str, string $pattern) : bool {
        return preg_match($pattern, $str) === 1;
    }

}