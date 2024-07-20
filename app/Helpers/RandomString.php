<?php

namespace Helpers;

final class RandomString
{
    private function __construct() {}
    public final static function generateAlphanumericString(int $length) : string
    {
        $alphanumeric = array_merge(range('a', 'z'), range('A', 'Z'), range(0, 9));
        return self::randomString($alphanumeric, $length);
    }
    public final static function generateUpperCaseString(int $length) : string
    {
        $upperCase = range('A', 'Z');
        return self::randomString($upperCase, $length);
    }
    public final static function generateLowerCaseString(int $length) : string
    {
        $lowerCase = range('a', 'z');
        return self::randomString($lowerCase, $length);
    }
    public final static function generateNumericString(int $length) : string {
        $numeric = range(0, 9);
        return self::randomString($numeric, $length);
    }
    private static function randomString(array $array, int $length) : string
    {
        $text = '';
        // Generate the random string.
        for ($i=0; $i < $length; $i++) {
            $random = array_rand($array);
            $text .= $array[$random];
        }
        return $text;
    }
}