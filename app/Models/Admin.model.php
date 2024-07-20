<?php

namespace Models;

use Core\Database;
use Core\Model;
use Models\User;
use Helpers\FormInputHandler;
use Helpers\StringValidator;
use Helpers\FileUploadValidator;
use Helpers\NumberValidator;
use Helpers\RandomString;
use Libraries\Mailer;

class Admin extends User implements FetchProfile, UpdateProfile
{

    public function fetchNumberOfAdmins(): int
    {
        return Model::table('users')->where('user_role', 'admin')->count();
    }

    public function toggleAccountStatus(string $userID = ''): bool
    {
        $fields = [':user_ID' => $userID];
        $query = "UPDATE `users` SET `status` = IF(`status` = 1, 0, 1) WHERE `user_id` = :user_ID";
        if (Database::executeQuery($query, $fields)) {
            return true;
        }
        else {
            return false;
        }
    }

    public function addCategory(array $requestData = [], array $fileData = []) : array 
    {
        $errors = [];
        $fields = ['categoryName', 'categoryDescription'];
        $categoryObj = new Category();
        if(! FormInputHandler::arePostKeysPresent($fields)) {
            $errors[] = 'Please try again. An error occurred while processing the data you entered.';
        }
        else {
            $fields = [
                ':categoryName' => FormInputHandler::sanitizeInput($requestData['categoryName']),
                ':categoryDescription' => FormInputHandler::sanitizeInput($requestData['categoryDescription']),
            ];
            foreach ($fields as $field) {
                if (StringValidator::isEmpty($field)) {
                    $errors[] = 'All fields are required, please do not leave them blank.';
                    break;
                }
            }

            $errors = array_merge(
                $errors,
                $categoryObj->validateCategoryName($fields[':categoryName']),
                $categoryObj->validateCategoryDescription($fields[':categoryDescription']),
                $categoryObj->validateCategoryImage($fileData['categoryImage']),
            );
            if ($categoryObj->checkCategoryNameExists($fields[':categoryName'])) {
                $errors[] = 'The category Name is already registered.';
            }
            if (count($errors) == 0) {
                $fileExtension  = pathinfo($fileData['categoryImage']['name'], PATHINFO_EXTENSION);
                $imageName = RandomString::generateAlphanumericString(100) . '.' . $fileExtension;
                $fields[':categoryImage'] = $imageName;

                $insertCategoryQuery = "INSERT INTO `categories` (`name`, `description`, `image_url`) VALUES (:categoryName, :categoryDescription, :categoryImage)";

                if (Database::executeQuery($insertCategoryQuery, $fields)) {
                    if (! FileUploadValidator::moveFile($fileData['categoryImage']['tmp_name'], UPLOAD_IMAGES, $fields[':categoryImage'])) {
                        $errors[] = 'All data added successfully, but there was an issue updating photo. Please try again later.';
                    }
                }
                else {
                    $errors[] = 'Something went wrong. Please try again.';
                }
            }
        }
        return $errors;
    }

    public function updateCategory(array $requestData = [], array $fileData = []) : array
    {
        $errors = [];
        $fields = ['categoryID', 'categoryName', 'categoryDescription'];
        $categoryObj = new Category();
        if(! FormInputHandler::arePostKeysPresent($fields)) {
            $errors[] = 'Please try again. An error occurred while processing the data you entered.';
        }
        else {
            $fields = [
                ':categoryID' => FormInputHandler::sanitizeInput($requestData['categoryID']),
                ':categoryName' => FormInputHandler::sanitizeInput($requestData['categoryName']),
                ':categoryDescription' => FormInputHandler::sanitizeInput($requestData['categoryDescription']),
            ];

            foreach ($fields as $field) {
                if (StringValidator::isEmpty($field)) {
                    $errors[] = 'All fields are required, please do not leave them blank.';
                    break;
                }
            }

            $errors = array_merge(
                $errors,
                $categoryObj->validateCategoryName($fields[':categoryName']),
                $categoryObj->validateCategoryDescription($fields[':categoryDescription']),
            );

            if ($categoryObj->isCategoryNameTaken($fields[':categoryName'], $fields[':categoryID'])) {
                $errors[] = 'The category Name is already registered.';
            }

            if (empty($fileData['categoryImage']['name'])) {
                $fields[':categoryImage'] = null;
            }
            else {
                $imageErrors = $categoryObj->validateCategoryImage($fileData['categoryImage']);
                if (count($imageErrors) > 0) {
                    $errors = array_merge($errors, $imageErrors);
                }
                else {
                    $fileExtension  = pathinfo($fileData['categoryImage']['name'], PATHINFO_EXTENSION);
                    $imageName = RandomString::generateAlphanumericString(100) . '.' . $fileExtension;
                    $fields[':categoryImage'] = $imageName;
                }
            }

            if (count($errors) == 0) {
                $selectImageUserQuery = "SELECT `image_url` FROM `categories` WHERE `category_ID` = :categoryID;";
                $imageResult = Database::executeQuery($selectImageUserQuery, $fields);
                $updateCategoryQuery = "UPDATE 
                                            `categories` 
                                        SET 
                                            `name` = :categoryName, 
                                            `description` = :categoryDescription, 
                                            `image_url` = IF(ISNULL(:categoryImage), `image_url`, :categoryImage)
                                        WHERE `category_ID` = :categoryID";
                if (! Database::executeQuery($updateCategoryQuery, $fields)) {
                    $errors[] = 'Something went wrong. Please try again.';
                }
                else {
                    if ($fields[':categoryImage'] != null) {
                        if (FileUploadValidator::moveFile($fileData['categoryImage']['tmp_name'], UPLOAD_IMAGES, $fields[':categoryImage'])) {
                            FileUploadValidator::removeFile(UPLOAD_IMAGES, $imageResult[0]['image_url']);
                        }
                        else {
                            $errors[] = 'All category data has been updated successfully, but there was an issue updating category photo. Please try again later.';
                        }
                    }
                }

            }
        }
        return $errors;
    }

    public function deleteCategory(string $categoryID = '') : bool {
        $categoryImage = Model::table('categories')->select('image_url')->where('category_ID', $categoryID)->get();
        if (Model::table('categories')->where('category_ID', $categoryID)->delete()) {
            FileUploadValidator::removeFile(UPLOAD_IMAGES, $categoryImage[0]['image_url']);
            return true;
        }
        return false;
    }


    public function sendEmail(array $requestData = [], string $feedbackID = '') : array {
        $errors = [];
        $fields = ['message'];
        if(! FormInputHandler::arePostKeysPresent($fields)) {
            $errors[] = 'Please try again. An error occurred while processing the data you entered.';
        }
        else {
            $fields = [
                ':message' => FormInputHandler::sanitizeInput($requestData['message']),
                ':feedbackID' => $feedbackID,
            ];
            foreach ($fields as $field) {
                if (StringValidator::isEmpty($field)) {
                    $errors[] = 'All fields are required, please do not leave them blank.';
                    break;
                }
            }
            $query = "SELECT `email` FROM `feedbacks` WHERE `feedback_ID` = :feedbackID";
            $email = Database::executeQuery($query, $fields);
            if (count(($email)) > 0) {
                $email = $email[0]['email'];
                $from = "mohamedt4438@gmail.com";
                if (! Mailer::sendEmail($from, $from, $email, $email, 'hi', $fields[':message'])) {
                    $errors[] = 'Please try again. An error occurred.';
                }
            }
            else {
                $errors[] = 'Please try again. An error occurred.';
            }
        }
        return $errors;
    }

    public function deleteFeedback(string $feedbackID = ''): bool
    {
        return Model::table('feedbacks')->where('feedback_ID', $feedbackID)->delete();
    }

    public function addUser(array $requestData = []): array
    {
        $fields = ['firstName', 'lastName', 'birthDate', 'gender', 'email', 'userRole', 'status', 'password', 'confirmPassword'];
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
                ':userRole' => FormInputHandler::sanitizeInput($requestData['userRole']),
                ':status' => FormInputHandler::sanitizeInput($requestData['status']),
                ':password' => FormInputHandler::sanitizeInput($requestData['password']),
                ':confirmPassword' => FormInputHandler::sanitizeInput($requestData['confirmPassword']),
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
                $this->validateBirthDate($fields[':birthDate']),
                $this->validateGender($fields[':gender']),
                $this->validateEmail($fields[':email']),
                $this->validateRole($fields[':userRole']),
                $this->validatePassword($fields[':password'], $fields[':confirmPassword'])
            );
            if (count($errors) == 0) {
                if ($this->checkEmailExists($fields[':email'])) {
                    $errors[] = 'This email address is registered on the site. Please enter the correct email.';
                }
                else {
                    $fields[':password'] = password_hash($fields[':password'], PASSWORD_DEFAULT);
                    $query = "INSERT INTO `users` (`first_name`, `last_name`, `birth_date`, `gender`, `user_role`, `status`, `email`, `password`) VALUES (:firstName, :lastName, :birthDate, :gender, :userRole, :status, :email, :password);";
                    if ($fields[':userRole'] == 'buyer') {
                        $query .= "SET @last_user_id = LAST_INSERT_ID();
                                INSERT INTO `buyers` (`user_id`) VALUES (@last_user_id);";
                    }
                    if (! Database::executeQuery($query, $fields)) {
                        $errors[] = 'Something went wrong. Please try again.';
                    }
                }
            }
        }
        return $errors;
    }

    public function addFrame(string $userID = '', array $requestData = [], array $fileData = []) : array {
        $frameObj = new Frame();
        $categoryObj = new Category();
        $errors = [];
        $fields = [
            'model', 'category', 'price', 'gender', 'description', 'frameMaterial',
            'frameStyle', 'frameShape', 'nosePads', 'color', 'quantity', 'frameWidth', 'bridgeWidth', 'templeLength'];
        $files = ['images'];
        if(! FormInputHandler::arePostKeysPresent($fields) || ! FormInputHandler::areFileKeysPresent($files)) {
            $errors[] = 'Please try again. An error occurred while processing the data you entered.';
        }
        else {
            $fields = [
                ':userID' => $userID,
                ':model' => FormInputHandler::sanitizeInput($requestData['model']),
                ':category' => FormInputHandler::sanitizeInput($requestData['category']),
                ':price' => FormInputHandler::sanitizeInput($requestData['price']),
                ':gender' => FormInputHandler::sanitizeInput($requestData['gender']),
                ':description' => FormInputHandler::sanitizeInput($requestData['description']),
                ':frameMaterialOptionID' => FormInputHandler::sanitizeInput($requestData['frameMaterial']),
                ':frameStyleOptionID' => FormInputHandler::sanitizeInput($requestData['frameStyle']),
                ':frameShapeOptionID' => FormInputHandler::sanitizeInput($requestData['frameShape']),
                ':frameNosePadsOptionID' => FormInputHandler::sanitizeInput($requestData['nosePads']),
            ];
            $frameOptions = $frameObj->generateFrameOptions($requestData['color'], $requestData['quantity'], $requestData['frameWidth'], $requestData['bridgeWidth'], $requestData['templeLength']);
            $_POST['FrameOptions'] = $frameOptions;
            $frameImages = $frameObj->processFrameImages($fileData['images']);
            $errors = array_merge(
                $frameObj->validateModelName($fields[':model']),
                $categoryObj->validateCategoryID($fields[':category']),
                $frameObj->validatePrice((float)$fields[':price']),
                $frameObj->validateGender($fields[':gender']),
                $frameObj->validateDescription($fields[':description']),
                $frameObj->validateFrameOptions($frameOptions),
                $frameObj->validateFrameImages($frameImages),
                $frameObj->validateFrameMaterialID($fields[':frameMaterialOptionID']),
                $frameObj->validateFrameStyleID($fields[':frameStyleOptionID']),
                $frameObj->validateFrameShapeID($fields[':frameShapeOptionID']),
                $frameObj->validateFrameNosePadID($fields[':frameNosePadsOptionID']),
            );

            if (count($errors) == 0) {
                $ImagesFrameName = $frameObj->generateFrameImageNames($frameImages);
                $fields = array_merge(
                    $fields,
                    $ImagesFrameName,
                    ...$frameOptions,
                );

                $query = "INSERT INTO `frames`
                                        (`user_ID`, `model`, `category_ID`, `price`, `gender`, `description`, `frameMaterialOption_ID`, `frameStyleOption_ID`, `frameShapeOption_ID`, `frameNosePadsOption_ID`)
                            VALUES (:userID, :model, :category, :price, :gender, :description, :frameMaterialOptionID, :frameStyleOptionID, :frameShapeOptionID, :frameNosePadsOptionID);
                            SET @last_frame_id = LAST_INSERT_ID();
                            INSERT INTO `frameOptions` (`frame_ID`, `main_option`, `color`, `quantity`, `frame_width`, `bridge_width`, `temple_length`) VALUES ";
                foreach ($frameOptions as $key => $frameOption) {
                    $query .= "(@last_frame_id, :mainOption_$key, :color_$key, :quantity_$key, :frameWidth_$key, :bridgeWidth_$key, :templeLength_$key),";
                }
                $query = trim($query, ',') . ";";
                $query .= "INSERT INTO `frameImages`(`frame_ID`, `main_image`, `image_url`) VALUES ";
                for ($i=0; $i < 4; $i++) { 
                    $query .= "(@last_frame_id, :mainImage_$i, :imageName_$i),";
                }
                $query = trim($query, ',') . ";";
                if (! Database::executeQuery($query, $fields)) {
                    $errors[] = 'Unable to add frame information.';
                }
                else {
                    for ($i=0; $i < 4; $i++) { 
                        if (! FileUploadValidator::moveFile($frameImages[$i]['tmp_name'], UPLOAD_IMAGES, $ImagesFrameName[":imageName_$i"])) {
                            $errors[] = 'All data added successfully, but there was an issue updating photos. Please try again later.';
                        }
                    }
                }
            }
        }
        return $errors;
    }

    public function updateFrame(string $frameID = '', string $userID = '', array $requestData = [], array $fileData = []) : array {
        $frameObj = new Frame();
        $categoryObj = new Category();
        $errors = [];
        $fields = [
            'model', 'category', 'price', 'gender', 'description', 'frameMaterial',
            'frameStyle', 'frameShape', 'nosePads', 'oldOptions'];
        $files = ['images'];
        if(! FormInputHandler::arePostKeysPresent($fields) || ! FormInputHandler::areFileKeysPresent($files)) {
            $errors[] = 'Please try again. An error occurred while processing the data you entered.';
        }
        else {
            $fields = [
                ':frameID' => $frameID,
                ':userID' => $userID,
                ':model' => FormInputHandler::sanitizeInput($requestData['model']),
                ':category' => FormInputHandler::sanitizeInput($requestData['category']),
                ':price' => FormInputHandler::sanitizeInput($requestData['price']),
                ':gender' => FormInputHandler::sanitizeInput($requestData['gender']),
                ':description' => FormInputHandler::sanitizeInput($requestData['description']),
                ':frameMaterialOptionID' => FormInputHandler::sanitizeInput($requestData['frameMaterial']),
                ':frameStyleOptionID' => FormInputHandler::sanitizeInput($requestData['frameStyle']),
                ':frameShapeOptionID' => FormInputHandler::sanitizeInput($requestData['frameShape']),
                ':frameNosePadsOptionID' => FormInputHandler::sanitizeInput($requestData['nosePads']),
                ':oldOptions' => FormInputHandler::sanitizeInput($requestData['oldOptions']),
                ':updateDate' => date("Y-m-d H:i:s"),
            ];

            $frameImages = $frameObj->processFrameImages($fileData['images']);
            $errors = array_merge(
                $frameObj->validateModelName($fields[':model']),
                $categoryObj->validateCategoryID($fields[':category']),
                $frameObj->validatePrice((float)$fields[':price']),
                $frameObj->validateGender($fields[':gender']),
                $frameObj->validateDescription($fields[':description']),
                $frameObj->validateFrameMaterialID($fields[':frameMaterialOptionID']),
                $frameObj->validateFrameStyleID($fields[':frameStyleOptionID']),
                $frameObj->validateFrameShapeID($fields[':frameShapeOptionID']),
                $frameObj->validateFrameNosePadID($fields[':frameNosePadsOptionID']),
            );
            foreach ($fields[':oldOptions'] as $key => $oldOption) {
                $errors = array_merge(
                    $errors,
                    $frameObj->validateColor($oldOption['color']),
                    $frameObj->validateQuantity($oldOption['quantity']),
                    $frameObj->validateFrameWidth($oldOption['frameWidth']),
                    $frameObj->validateBridgeWidth($oldOption['bridgeWidth']),
                    $frameObj->validateTempleLength($oldOption['templeLength']),
                );
            }
            foreach ($frameImages as $key => $frameImage) {
                $frameImages[$key]['frameImageID'] = $requestData['imageID'][$key];
                if (empty($frameImage['name'])) {
                    unset($frameImages[$key]);
                }
                else {
                    $errors = array_merge(
                        $errors,
                        $frameObj->validateFrameImage($frameImage)
                    );
                }
            }
            $frameOptionFields = ['color', 'quantity', 'frameWidth', 'bridgeWidth', 'templeLength'];
            $frameOptions = [];
            if (FormInputHandler::arePostKeysPresent($frameOptionFields)) {
                $frameOptions = $frameObj->generateFrameOptions($requestData['color'], $requestData['quantity'], $requestData['frameWidth'], $requestData['bridgeWidth'], $requestData['templeLength']);
                $_POST['FrameOptions'] = $frameOptions;
                $errors = array_merge(
                    $errors,
                    $frameObj->validateFrameOptions($frameOptions),
                );
            }
            if (count($errors) == 0) {
                $frameImages = array_values($frameImages);
                $imagesFrameName = $frameObj->generateFrameImageNames($frameImages);
                $fields = array_merge(
                    $fields,
                    $imagesFrameName,
                    ...$frameOptions,
                );
                $oldFrameImages = [];
                for ($i=0; $i < count($frameImages); $i++) {
                    $frameImages = array_values($frameImages);
                    $oldFrameImages[] = Model::table('frameImages')->select('image_url')->where('frameImage_ID', $frameImages[$i]['frameImageID'])->get();
                }
                $query = "UPDATE 
                                `frames` 
                            SET 
                                `category_ID`= :category, 
                                `model`= :model,
                                `price`= :price,
                                `gender`= :gender,
                                `description`= :description,
                                `frameMaterialOption_ID`= :frameMaterialOptionID, 
                                `frameStyleOption_ID`= :frameStyleOptionID, 
                                `frameShapeOption_ID`= :frameShapeOptionID,
                                `frameNosePadsOption_ID`= :frameNosePadsOptionID
                            WHERE `frame_ID` = :frameID;";
                foreach ($fields[':oldOptions'] as $key => $oldOption) {
                    $query .= "UPDATE 
                                    `frameOptions`
                                SET
                                    `color` = :color_$key, 
                                    `quantity` = :quantity_$key, 
                                    `frame_width` = :frameWidth_$key, 
                                    `bridge_width` = :bridgeWidth_$key, 
                                    `temple_length` = :templeLength_$key,
                                    `update_date` = :updateDate
                                WHERE `frameOption_ID` = :frameOptionID_$key;";
                    $fields[":frameOptionID_$key"] = $oldOption['frameOptionID'];
                    $fields[":color_$key"] = $oldOption['color'];
                    $fields[":quantity_$key"] = $oldOption['quantity'];
                    $fields[":frameWidth_$key"] = $oldOption['frameWidth'];
                    $fields[":bridgeWidth_$key"] = $oldOption['bridgeWidth'];
                    $fields[":templeLength_$key"] = $oldOption['templeLength'];
                }
                $query = trim($query, ',') . ";";
                if (count($frameOptions) > 0) {
                    $query .= "INSERT INTO `frameOptions` (`frame_ID`, `main_option`, `color`, `quantity`, `frame_width`, `bridge_width`, `temple_length`) VALUES ";
                    foreach ($frameOptions as $key => $frameOption) {
                        $query .= "(:frameID, :mainOption_$key, :color_$key, :quantity_$key, :frameWidth_$key, :bridgeWidth_$key, :templeLength_$key),";
                    }
                    $query = trim($query, ',') . ";";
                }
                if (count($frameImages) > 0) {
                    foreach ($frameImages as $key => $imageFrame) {
                        $query .= "UPDATE `frameImages` SET `image_url` = :imageName_$key WHERE `frameImage_ID` = :frameImageID_$key;";
                    }
                }
                if (! Database::executeQuery($query, $fields)) {
                    $errors[] = 'Unable to update frame information.';
                }
                else {
                    unset($_POST['FrameOptions']);
                    for ($i = 0; $i < count($oldFrameImages); $i++) { 
                        if (FileUploadValidator::moveFile($frameImages[$i]['tmp_name'], UPLOAD_IMAGES, $imagesFrameName[":imageName_$i"])) {
                            FileUploadValidator::removeFile(UPLOAD_IMAGES, $oldFrameImages[$i][0]['image_url']);
                        }
                        else {
                            $errors[] = 'All frame data has been updated successfully, but there was an issue updating frame images. Please try again later.';
                        }
                    }
                }
            }
        }
        return $errors;
    }

    public function deleteFrame(string $frameID = '') : bool {
        $frameObj = new Frame();
        $frameImages = $frameObj->fetchFrameImages($frameID);
        for ($i=0; $i < $frameObj->getNumberOfFrameImages(); $i++) { 
            FileUploadValidator::removeFile(UPLOAD_IMAGES, $frameImages[$i]['image_url']);
        }
        return Model::table('frames')->where('frame_ID', $frameID)->delete();
    }

    public function deleteFrameOption(string $frameID = '', string $frameOptionID = '') : bool {
        if (Model::table('frameOptions')->where('frame_ID', $frameID)->count() > 1) {
            return Model::table('frameOptions')->where('frameOption_ID', $frameOptionID)->delete();
        }
        else {
            return false;
        }
    }

    public function fetchProfile(string $userID = ''): array {
        $fields = [':user_ID' => $userID];
        $selectUserData = "SELECT * FROM `users` WHERE `users`.`user_ID` = :user_ID";
        return Database::executeQuery($selectUserData, $fields);
    }

    public function updateProfile(string $userID = '', array $requestData = [], array $fileData = []): array 
    {
        $fields = [
            'firstName', 'lastName', 'birthDate', 'gender', 'email', 'status',
            'oldPassword', 'password', 'confirmPassword'];
        $errors = [];
        if(! FormInputHandler::arePostKeysPresent($fields)) {
            $errors[] = 'Please try again. An error occurred while processing the data you entered.';
        }
        else {
            $fields = [
                ':userID' => $userID,
                ':firstName' => FormInputHandler::sanitizeInput($requestData['firstName']),
                ':lastName' => FormInputHandler::sanitizeInput($requestData['lastName']),
                ':birthDate' => FormInputHandler::sanitizeInput($requestData['birthDate']),
                ':gender' => FormInputHandler::sanitizeInput($requestData['gender']),
                ':email' => FormInputHandler::sanitizeInput($requestData['email']),
                ':status' => FormInputHandler::sanitizeInput($requestData['status']),
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
                $this->validateBirthDate($fields[':birthDate']),
                $this->validateGender($fields[':gender']),
                $this->validateEmail($fields[':email']),
            );
            if ($this->isEmailTakenByAnotherUser($fields[':email'], $fields[':userID'])) {
                $errors[] = 'This email is already registered.';
            }
            $fields[':oldPassword'] = FormInputHandler::sanitizeInput($requestData['oldPassword']);
            $fields[':newPassword'] = FormInputHandler::sanitizeInput($requestData['password']);
            $fields[':confirmPassword'] = FormInputHandler::sanitizeInput($requestData['confirmPassword']);

            $selectUserPasswordQuery = "SELECT `password` FROM `users` WHERE `user_ID` = :userID;";
            $oldPasswordResult = Database::executeQuery($selectUserPasswordQuery, $fields);
            if (empty($fields[':newPassword'])) {
                $fields[':newPassword'] = $oldPasswordResult[0]['password'];
            }
            else {
                if (! password_verify($fields[':oldPassword'], $oldPasswordResult[0]['password'])) {
                    $errors[] = 'Your old password is incorrect.';
                }
                else {
                    $passwordErrors = $this->validatePassword($fields[':newPassword'], $fields[':confirmPassword']);
                    if (count($passwordErrors) > 0) {
                        $errors = array_merge($errors, $passwordErrors);
                    }
                    else {
                        $fields[':newPassword'] = password_hash($fields[':newPassword'], PASSWORD_DEFAULT);
                    }
                }
            }
            if (count($errors) == 0) {
                $query = "UPDATE
                                                        `users`
                                                    SET
                                                        `first_name` = :firstName,
                                                        `last_name` = :lastName,
                                                        `email` = :email,
                                                        `password` = :newPassword,
                                                        `birth_date` = :birthDate,
                                                        `gender` = :gender,
                                                        `status` = :status
                                                    WHERE
                                                        `users`.`user_ID` = :userID;";
                $updateResult = Database::executeQuery($query, $fields);
                if (! $updateResult) {
                    $errors[] = 'Unable to update user information.';
                }
            }
        }
        return $errors;
    }

    public function updateOrderStatus(string $orderID = '', array $requestData = []) : array 
    {
        $fields = ['status', 'phase', 'paymentStatus'];
        $errors = [];
        if(FormInputHandler::arePostKeysPresent($fields)) {
            $fields = [
                ':order_ID' => FormInputHandler::sanitizeInput($orderID),
                ':order_status' => FormInputHandler::sanitizeInput($requestData['status']),
                ':payment_status' => FormInputHandler::sanitizeInput($requestData['paymentStatus']),
                ':order_phase' => FormInputHandler::sanitizeInput($requestData['phase']),
            ];
            foreach ($fields as $field) {
                if (StringValidator::isEmpty($field)) {
                    $errors[] = 'All fields are required, please do not leave them blank.';
                    break;
                }
            }
            if (!NumberValidator::isInRange($fields[':order_status'], 0, 2)) {
                $errors[] = 'The order status value is invalid.';
            }
            if (!NumberValidator::isInRange($fields[':order_phase'], 0, 3)) {
                $errors[] = 'The order phase value is invalid.';
            }
            if (!NumberValidator::isInRange($fields[':payment_status'], 0, 1)) {
                $errors[] = 'The payment status value is invalid.';
            }
            if (count($errors) == 0) {
                $query = "UPDATE `orders` SET `order_status` = :order_status, `payment_status` = :payment_status, `order_phase` = :order_phase WHERE `order_ID` = :order_ID;";
                if ($fields[':order_status'] == 2) {
                    
                }
                if (!Database::executeQuery($query, $fields)) {
                    $errors[] = 'There Is An Error Please Try Again.';
                }
            }
        }
        return $errors;
    }
}