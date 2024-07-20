<?php

namespace Helpers;

use DateTime;

final class DateValidator
{
    private function __construct() {}
    public final static function isValidDate(string $date, string $format = 'Y-m-d') : bool
    {
        $dateTime = DateTime::createFromFormat($format, $date);
        $errors = DateTime::getLastErrors();
        if ($dateTime === false) {
            return false;
        }
        if (is_array($errors)) {
            if ($errors['warning_count'] > 0 || $errors['error_count'] > 0) {
                return false;
            }
        }
        return true;
    }

    public final static function calculateYearsDifference(string $date) : int
    {
        if (self::isValidDate($date)) {
            $dateObj = new DateTime($date);
            $currentDateObj = new DateTime();
            $interval = $currentDateObj->diff($dateObj);
            return $interval->y;
        }
        return 0;
    }
}