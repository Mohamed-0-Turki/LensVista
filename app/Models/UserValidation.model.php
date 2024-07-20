<?php

namespace Models;

use Core\Database;
use Helpers\DateValidator;
use Helpers\NumberValidator;
use Helpers\StringValidator;


class UserValidation 
{
    public function validateUser(User $user): array
    {
      return array_merge(
        $this->validateFirstName($user->getFirstName()),
        $this->validateLastName($user->getLastName()),
        $this->validateBirthDate($user->getBirthDate()),
        $this->validateGender($user->getGender()),
        $this->validateRole($user->getUserRole()),
        $this->validateEmail($user->getEmail()),
        $this->validatePassword($user->getPassword(), $user->getConfirmPassword()),
      );
    }

    protected function validateFirstName(string $name = ''): array
    {
        $errors = [];
        if (!StringValidator::isLengthValid($name, 3, 50)) {
            $errors[] = 'First name must be between 3 and 50 characters and contain only alphabetic characters.';
        }
        return $errors;
    }

    protected function validateLastName(string $name = ''): array
    {
        $errors = [];
        if (!StringValidator::isLengthValid($name, 3, 50)) {
            $errors[] = 'Last name must be between 3 and 50 characters and contain only alphabetic characters.';
        }
        return $errors;
    }
    protected function validateBirthDate(string $data = ''): array
    {
        $errors = [];
        if (!DateValidator::isValidDate($data)) {
            $errors[] = $data . ' is not a valid date';
        }
        if (DateValidator::calculateYearsDifference($data) < 9) {
            $errors[] = 'Sorry, users under the age of 9 are not allowed.';
        }
        return $errors;
    }
    protected function validateGender(string $gender = ''): array
    {
        $errors = [];
        if (!in_array($gender, ['male', 'female'])) {
            $errors[] = 'Invalid gender. Please choose either "male" or "female".';
        }
        return $errors;
    }
    protected function validateRole(string $role = ''): array
    {
        $errors = [];
        if (!in_array($role, ['admin', 'buyer'])) {
            $errors[] = 'Invalid role. Please choose either "admin" or "buyer".';
        }
        return $errors;
    }
    protected function validateEmail(string $email = ''): array
    {
        $errors = [];
        if (!StringValidator::isValidEmail($email)) {
            $errors[] = 'Please enter a valid email address.';
        }
        return $errors;
    }
    public function checkEmailExists(string $email = ''): bool
    {
        $query = "SELECT `email` FROM `users` WHERE `email` = :email";
        $data = Database::executeQuery($query, [':email' => $email]);
        if (count($data) != 0) {
            return true;
        }
        return false;
    }
    protected function validatePhoneNumber(string $phoneNumber = ''): array
    {
        $errors = [];
        if (!NumberValidator::isNumeric($phoneNumber)) {
            $errors[] =  'Phone number is empty or contains invalid characters.';
        }
        if (strlen($phoneNumber) < 3) {
            $errors[] =  'Phone number should contain at least 3 digits.';
        }
        return $errors;
    }
    protected function isEmailTakenByAnotherUser(string $email = '', string $userID = ''): bool
    {
        $fields = [
            ':email' => $email,
            ':userID' => $userID
        ];
        $queryGetEmail = "SELECT `email` FROM `users` WHERE `email` = :email AND `user_ID` != :userID;";
        $emailResult = Database::executeQuery($queryGetEmail, $fields);
        if (count($emailResult) > 0) {
            return true;
        }
        return false;
    }
    public function validatePassword(string $password = '', string $confirmPassword = ''): array
    {
        $errors = [];
        if (!StringValidator::isLengthValid($password, 8, 28)) {
            $errors[] = 'Password must be between 8 and 28 characters in length.';
        }
        if (!preg_match('/[A-Z]/', $password) && !preg_match('/[a-z]/', $password)) {
            $errors[] = 'Password must contain at least one lowercase or uppercase letter.';
        }
        if (!preg_match('/[0-9]/', $password)) {
            $errors[] = 'Password must contain at least one digit.';
        }
        if ($password !== $confirmPassword) {
            $errors[] = 'Passwords do not match.';
        }
        return $errors;
    }
}