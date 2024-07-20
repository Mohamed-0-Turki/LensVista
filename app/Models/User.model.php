<?php

namespace Models;

use Core\Database;
use Core\Model;
use Helpers\FileUploadValidator;
use Helpers\FormInputHandler;
use Helpers\StringValidator;


class User extends UserValidation
{
    private string $firstName;
    private string $lastName;
    private string $gender;
    private string $userRole;
    private string $birthDate;
    private string $email;
    private string $password;
    private string $confirmPassword;

    public function __construct(
        string $firstName = '',
        string $lastName = '',
        string $gender = '',
        string $userRole = '',
        string $birthDate = '',
        string $email = '',
        string $password = ''
    ) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->gender = $gender;
        $this->userRole = $userRole;
        $this->birthDate = $birthDate;
        $this->email = $email;
        $this->password = $password;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName = ''): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName = ''): void
    {
        $this->lastName = $lastName;
    }

    public function getGender(): string
    {
        return $this->gender;
    }

    public function setGender(string $gender = ''): void
    {
        $this->gender = $gender;
    }

    public function getUserRole(): string
    {
        return $this->userRole;
    }

    public function setUserRole(string $userRole = ''): void
    {
        $this->userRole = $userRole;
    }

    public function getBirthDate(): string
    {
        return $this->birthDate;
    }

    public function setBirthDate(string $birthDate = ''): void
    {
        $this->birthDate = $birthDate;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email = ''): void
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password = ''): void
    {
        $this->password = $password;
    }
    public function getConfirmPassword(): string
    {
        return $this->confirmPassword;
    }

    public function setConfirmPassword(string $confirmPassword = ''): void
    {
        $this->confirmPassword = $confirmPassword;
    }

    public function fetchNumberOfUsers(): int
    {
        return Model::table('users')->count();
    }
    public function fetchRecentUserRegistrations() : array
    {
        $query = "SELECT DATE(create_date) AS `day`, COUNT(user_ID) AS `user_count` FROM `users` WHERE create_date >= CURDATE() - INTERVAL 5 DAY GROUP BY DATE(create_date) ORDER BY `day` DESC;";
        return Database::executeQuery($query);
    }
    public function fetchUserDetails($sort = 'DESC'): array {
        return Model::table('users')->select('user_ID', 'first_name', 'last_name', 'email', 'gender', 'user_role', 'status', 'create_date')->orderBy('create_date', $sort)->get();
    }

    public function sendFeedback(array $requestData = []): array
    {
        $fields = ['firstName', 'lastName', 'email', 'phoneNumber', 'message'];
        $errors = [];
        if(! FormInputHandler::arePostKeysPresent($fields)) {
            $errors[] = 'Please try again. An error occurred while processing the data you entered.';
        }
        else {
            $fields = [
                ':firstName' => FormInputHandler::sanitizeInput($requestData['firstName']),
                ':lastName' => FormInputHandler::sanitizeInput($requestData['lastName']),
                ':email' => FormInputHandler::sanitizeInput($requestData['email']),
                ':phoneNumber' => FormInputHandler::sanitizeInput($requestData['phoneNumber']),
                ':message' => FormInputHandler::sanitizeInput($requestData['message']),
            ];
            foreach ($fields as $field) {
                if (StringValidator::isEmpty($field)) {
                    $errors[] = 'All fields are required, please do not leave them blank.';
                    break;
                }
            }
            $errors = array_merge(
                $errors,
                $this->validateFirstName($fields[':firstName']),
                $this->validateLastName($fields[':lastName']),
                $this->validateEmail($fields[':email']),
                $this->validatePhoneNumber($fields[':phoneNumber'])
            );
            if (count($errors) == 0) {
                $query = "INSERT INTO `feedbacks` (`first_name`, `last_name`, `email`, `phone_number`, `message`) VALUES (:firstName, :lastName, :email, :phoneNumber, :message)";
                if (! Database::executeQuery($query, $fields)) {
                    $errors[] = 'Something went wrong. Please try again.';
                }
            }
        }
        return $errors;
    }

    public function deleteUserAccount(string $userID = ''): bool
    {
        $fields = [
            ':userID' => $userID
        ];
        $imageUserUrl = '';
        $imageUser = Model::table('buyers')->select('image_url')->where('user_ID', $userID)->get();
        if (count($imageUser) > 0) {
            $imageUserUrl = $imageUser[0]['image_url'];
        }
        $deleteQuery = "DELETE FROM `users` WHERE `users`.`user_ID` = :userID";
        if(Database::executeQuery($deleteQuery, $fields)) {
            if ($imageUserUrl != null) {
                FileUploadValidator::removeFile(UPLOAD_IMAGES, $imageUserUrl);
            }
            return true;
        }
        return false;
    }

    public function deleteProfileImage(string $userID = ''): bool
    {
        $fields = [
            ':userID' => $userID
        ];
        $queryGetUserImage = "SELECT `image_url` FROM `buyers` WHERE `user_ID` = :userID;";
        $imageResult = Database::executeQuery($queryGetUserImage, $fields);
        $deleteImageQuery = "UPDATE `buyers` SET `image_url` = NULL WHERE `user_ID` = :userID;";
        if (Database::executeQuery($deleteImageQuery, $fields)) {
            if ($imageResult[0]['image_url'] != null) {
                return FileUploadValidator::removeFile(UPLOAD_IMAGES, $imageResult[0]['image_url']);
            }
        }
        return false;
    }
    public function validateProfileImage(array $file = []): array
    {
        $errors = [];
        if (! FileUploadValidator::validateExtension($file['name'], ['jpeg', 'jpg', 'png', 'webp'])) {
            $errors[] = 'Invalid file extension.';
        }
        elseif (! FileUploadValidator::validateType($file['type'], ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'])) {
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

    public function cancelOrder(string $orderID = ''): bool
    {
        $fields = [
            ':orderID' => $orderID
        ];
        $updateOrderStatusQuery = "UPDATE `orders` SET `order_status` = 0 WHERE `order_ID` = :orderID;";
        return Database::executeQuery($updateOrderStatusQuery, $fields);
    }

    public function fetchAllComments(string $frameID = '') : array {
        $query = "SELECT `comments`.*, `users`.`first_name`, `users`.`last_name` FROM `comments` INNER JOIN `users` ON `comments`.`user_ID` = `users`.`user_ID` WHERE `comments`.`frame_ID` = :frameID;";
        return Database::executeQuery($query, [':frameID' => $frameID]);
    }

    public function deleteComment(string $commentID = '', string $userID = '') : bool {
        if (empty($userID)) {
            return Model::table('comments')->where('comment_ID', $commentID)->delete();
        }
        else {
            return Model::table('comments')->where('comment_ID', $commentID)->where('user_ID', $userID)->delete();
        }
    }
}