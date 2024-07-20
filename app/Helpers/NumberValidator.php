<?php

namespace Helpers;

final class NumberValidator
{
    private function __construct() {}

    public final static function isInRange($number, float $min, float $max) : bool {
        return $number >= $min && $number <= $max;
    }

    public final static function isInteger($number) : bool {
        return filter_var($number, FILTER_VALIDATE_INT) !== false;
    }

    public final static function isFloat($number) : bool {
        return filter_var($number, FILTER_VALIDATE_FLOAT) !== false;
    }

    public final static function isPositive($number) : bool {
        return $number > 0;
    }
    public final static function isNumeric(string $str) : bool {
        return ctype_digit($str);
    }
    public final static function isNonNegative($number) : bool {
        return $number >= 0;
    }

    public final static function matchesPattern($number, string $pattern) : bool {
        return preg_match($pattern, strval($number)) === 1;
    }
}