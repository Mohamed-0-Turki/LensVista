<?php

namespace Models;

use Core\Database;
use Helpers\CookieManager;
use Helpers\DateValidator;
use Helpers\FormInputHandler;
use Helpers\RandomString;
use Helpers\SessionManager;
use Helpers\StringValidator;
use Libraries\Mailer;

class Auth
{
    public function login(array $requestData = []): array
    {
        $fields = ['email', 'password'];
        $errors = [];
        if(! FormInputHandler::arePostKeysPresent($fields)) {
            $errors[] = 'Please try again. An error occurred while processing the data you entered.';
        }
        else {
            $fields = [
                ':email' => FormInputHandler::sanitizeInput($requestData['email']),
                ':password' => FormInputHandler::sanitizeInput($requestData['password'])
            ];
            if (StringValidator::isEmpty($fields[':email']) || StringValidator::isEmpty($fields[':password'])) {
                $errors[] = 'All fields are required, please do not leave them blank.';
            }
            else {
                if (! StringValidator::isValidEmail($fields[':email'])) {
                    $errors[] = 'Please enter a valid email address.';
                }
                else {
                    $query = "SELECT * FROM `users` WHERE `email` = :email";
                    $data = Database::executeQuery($query, $fields);
                    if (count($data) == 0) {
                        $errors[] = 'This email address is not registered on the site. Please enter the correct email.';
                    }
                    else {
                        if (password_verify($fields[':password'], $data[0]['password'])) {
                            if ($data[0]['status'] === 0) {
                                $errors[] = 'Contact one of the site managers to activate the account again.';
                            }
                            else {
                                $sessionData = [
                                    'userID' => $data[0]['user_ID'],
                                    'role'   => $data[0]['user_role'],
                                ];
                                SessionManager::setSessionVariable('USER', $sessionData);
                                if (isset($requestData['rememberMe']) && $requestData['rememberMe'] === 'on') {
                                    $authenticationData = [
                                        ':user_ID' => $data[0]['user_ID'],
                                        ':token' => RandomString::generateAlphanumericString(60),
                                        ':token_expiration' => Date('Y-m-d', strtotime(Date('Y-m-d') . ' +1 year')),
                                    ];
                                    $query = "SELECT `user_ID` FROM `authentications` WHERE `user_ID` = :user_ID";
                                    $data = Database::executeQuery($query, $authenticationData);
                                    if (count($data) == 0) {
                                        $query = "INSERT INTO `authentications` (`user_ID`, `token`, `token_expiration`) VALUES (:user_ID, :token, :token_expiration)";
                                    } else {
                                        $query = "UPDATE `authentications` SET `token` = :token, `token_expiration` = :token_expiration WHERE `user_ID` = :user_ID";
                                    }
                                    $result = Database::executeQuery($query, $authenticationData);
                                    if ($result) {
                                        CookieManager::setCookie('TOKEN', $authenticationData[':token'], time() + (60 * 60 * 24 * 365));
                                    }
                                }
                            }
                        } else {
                            $errors[] = 'Wrong password. Please try again.';
                        }
                    }
                }
            }
        }
        return $errors;
    }

    public function signup(array $requestData = []): array
    {
        $fields = ['firstName', 'lastName', 'birthDate', 'gender', 'email', 'password', 'confirmPassword'];
        $errors = [];
        if(! FormInputHandler::arePostKeysPresent($fields)) {
            $errors[] = 'Please try again. An error occurred while processing the data you entered.';
        }
        else {
            $fields = [
                ':firstName' => FormInputHandler::sanitizeInput($requestData['firstName']),
                ':lastName' => FormInputHandler::sanitizeInput($requestData['lastName']),
                ':birthDate' => FormInputHandler::sanitizeInput($requestData['birthDate']),
                ':gender' => FormInputHandler::sanitizeInput($requestData['gender']),
                ':email' => FormInputHandler::sanitizeInput($requestData['email']),
                ':password' => FormInputHandler::sanitizeInput($requestData['password']),
                ':confirmPassword' => FormInputHandler::sanitizeInput($requestData['confirmPassword']),
            ];
            foreach ($fields as $field) {
                if (StringValidator::isEmpty($field)) {
                    $errors[] = 'All fields are required, please do not leave them blank.';
                    break;
                }
            }
            $userObj = new User($fields[':firstName'], $fields[':lastName'], $fields[':gender'], 'buyer', $fields[':birthDate'], $fields[':email'], $fields[':password']);
            $userObj->setConfirmPassword($fields[':confirmPassword']);
            $errors = array_merge(
                $errors,
                $userObj->validateUser($userObj)
            );
            if (!(isset($requestData['privacy']) && $requestData['privacy'] === 'on')) {
                $errors[] = 'Please accept the terms and conditions.';
            }
            if (count($errors) == 0) {
                if ($userObj->checkEmailExists($fields[':email'])) {
                    $errors[] = 'This email address is registered on the site. Please enter the correct email.';
                }
                else {
                    $fields[':password'] = password_hash($fields[':password'], PASSWORD_DEFAULT);
                    $query = "INSERT INTO `users` (`first_name`, `last_name`, `birth_date`, `gender`, `email`, `password`) VALUES (:firstName, :lastName, :birthDate, :gender, :email, :password);
                            SET @last_user_id = LAST_INSERT_ID();
                            INSERT INTO `buyers` (`user_id`) VALUES (@last_user_id);";
                    if (! Database::executeQuery($query, $fields)) {
                        $errors[] = 'Something went wrong. Please try again.';
                    }
                }
            }
        }
        return $errors;
    }

    public function isLogIn(): bool
    {
        return isset($_SESSION['USER']);
    }

    public function logout(): void
    {
        if (isset($_SESSION['USER'])) {
            if (CookieManager::isCookieSet('TOKEN')) {
                $query = "DELETE FROM `authentications` WHERE `user_ID` = :user_ID";
                Database::executeQuery($query, [':user_ID' => $_SESSION['USER']['userID']]);
                CookieManager::deleteCookie('TOKEN');
            }
            SessionManager::unsetSessionVariable('USER');
        }
    }

    public function validateAndSendVerificationCode(array $requestData = []): array
    {
        $fields = ['email'];
        $errors = [];
        if(! FormInputHandler::arePostKeysPresent($fields)) {
            $errors[] = 'Please try again. An error occurred while processing the data you entered.';
        }
        else {
            $fields = [
                ':email' => FormInputHandler::sanitizeInput($requestData['email']),
                ':verification_code' => RandomString::generateNumericString(4),
            ];
            if (StringValidator::isEmpty($fields[':email'])) {
                $errors[] = 'All fields are required, please do not leave them blank.';
            }
            if (! StringValidator::isValidEmail($fields[':email'])) {
                $errors[] = 'Please enter a valid email address.';
            }
            else {
                $query = "SET @userID = (SELECT `user_ID` FROM `users` WHERE `email` = :email);
                        UPDATE `users` SET `verification_code` = :verification_code WHERE `user_ID` = @userID;";
                $result = Database::executeQuery($query, $fields);
                if (!$result) {
                    $errors[] = 'This email address is not registered on the site. Please enter the correct email.';
                }
                else {
                    $subject = 'Verification Code From LensVista';
                    $body = 'Verification Code: ' . $fields[':verification_code'];
                    if (!Mailer::sendEmail('mohamedt4438@gmail.com', 'lensVista', $fields[':email'],  $fields[':email'], $subject, $body)) {
                        $errors[] = 'Something went wrong. Please try again.';
                    }
                }
            }
        }
        return $errors;
    }

    public function verifyEmailAndCode(array $requestData = []): array
    {
        $fields = ['email', 'verificationCode'];
        $errors = [];
        if (! FormInputHandler::arePostKeysPresent($fields)) {
            $errors[] = 'Please try again. An error occurred while processing the data you entered.';
        }
        else {
            $fields = [
                ':email' => FormInputHandler::sanitizeInput($requestData['email']),
                ':verification_code' => FormInputHandler::sanitizeInput($requestData['verificationCode']),
            ];
            if (StringValidator::isEmpty($fields[':verification_code'])) {
                $errors[] = 'All fields are required, please do not leave them blank.';
            }
            else {
                $query = "SELECT `user_ID` FROM `users` WHERE `email` = :email AND `verification_code` = :verification_code";
                $data = Database::executeQuery($query, $fields);
                if (count($data) == 0) {
                    $errors[] = 'The verification code you entered is incorrect. Please verify this by checking your email.';
                }
                else {
                    SessionManager::setSessionVariable('userID', $data[0]['user_ID']);
                }
            }
        }
        return $errors;
    }

    public function resetPassword(array $requestData = []): array
    {
        $userObj = new User();
        $fields = ['password', 'confirmPassword'];
        $errors = [];
        if (! FormInputHandler::arePostKeysPresent($fields)) {
            $errors[] = 'Please try again. An error occurred while processing the data you entered.';
        }
        else {
            $fields = [
                ':userID' => $_SESSION['userID'],
                ':password' => FormInputHandler::sanitizeInput($requestData['password']),
                ':confirmPassword' => FormInputHandler::sanitizeInput($requestData['confirmPassword']),
            ];
            foreach ($fields as $field) {
                if (StringValidator::isEmpty($field)) {
                    $errors[] = 'All fields are required, please do not leave them blank.';
                    break;
                }
            }
            $errors = array_merge($errors, $userObj->validatePassword($fields[':password'], $fields[':confirmPassword']));
            if (count($errors) === 0) {
                $fields[':password'] = password_hash($fields[':password'], PASSWORD_DEFAULT);
                $query = "UPDATE `users` SET `password` = :password WHERE `user_ID` = :userID;";
                $result = Database::executeQuery($query, $fields);
                if (! $result) {
                    $errors[] = 'Please try again. An error occurred while processing the data you entered.';
                }
                else {
                    SessionManager::unsetSessionVariable('userID');
                }
            }
        }
        return $errors;
    }
}