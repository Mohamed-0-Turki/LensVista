<?php

namespace Models;

use Helpers\StringValidator;

class LocationValidation
{
    public function validateLocation(Location $location) : array {
        return array_merge(
            $this->validateStreetAddress($location->getStreetName()),
            $this->validateCity($location->getCity()),
            $this->validateNearestLandMark($location->getNearestLandMark()),
            $this->validateBuildingName($location->getBuildingName()),
        );
    }
    private function validateStreetAddress(string $streetAddress = ''): array {
        $errors = [];
        if (!StringValidator::isLengthValid($streetAddress, 3, 255)) {
            $errors[] = 'street address must be between 3 and 255 characters in length.';
        }
        return $errors;
    }
    private function validateCity(string $city = ''): array {
        $errors = [];
        if (!StringValidator::isLengthValid($city, 3, 20)) {
            $errors[] = 'city must be between 3 and 20 characters in length.';
        }
        return $errors;
    }

    private function validateNearestLandMark(string $nearestLandMark = ''): array {
        $errors = [];
        if (!StringValidator::isLengthValid($nearestLandMark, 3, 100)) {
            $errors[] = 'nearest Land Mark must be between 3 and 20 characters in length.';
        }
        return $errors;
    }
    private function validateBuildingName(string $buildingName = ''): array {
        $errors = [];
        if (!StringValidator::isLengthValid($buildingName, 3, 100)) {
            $errors[] = 'buildingName must be between 3 and 20 characters in length.';
        }
        return $errors;
    }
}