<?php

namespace Models;

use Core\Database;
use Core\Model;
use Helpers\DateValidator;
use Helpers\FileUploadValidator;
use Helpers\FormInputHandler;
use Helpers\RandomString;
use Helpers\StringValidator;

class Buyer extends User
{
    private string $phoneNumber;
    private ?Location $location;

    public function __construct(
        string $firstName = '',
        string $lastName = '',
        string $gender = '',
        string $userRole = '',
        string $birthDate = '',
        string $email = '',
        string $password = '',
        string $phoneNumber = '',
        ?Location $location = null
    ) {
        parent::__construct($firstName, $lastName, $gender, $userRole, $birthDate, $email, $password);
        $this->phoneNumber = $phoneNumber;
        $this->location = $location;
    }

    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber = ''): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    public function getLocation(): Location
    {
        return $this->location;
    }

    public function setLocation(Location $location): void
    {
        $this->location = $location;
    }

    public function fetchNumberOfBuyer(): int
    {
        return Model::table('buyers')->count();
    }

    public function userPhoneNumberExists(string $userID = ''): bool
    {
        $fields = [':user_ID' => $userID];
        $query = "SELECT IF(ISNULL(`phone_number`), 0, 1) AS `user_phone_number_status` FROM `buyers` WHERE `user_ID` = :user_ID";

        $result = Database::executeQuery($query, $fields);
        if ($result[0]['user_phone_number_status'] == 0) {
            return false;
        }
        return true;
    }

    public function userLocationExists(string $userID = ''): bool
    {
        $fields = [':user_ID' => $userID];

        $query = "SELECT IF(ISNULL(`street_name`) OR ISNULL(`city`) OR ISNULL(`nearest_landmark`) OR ISNULL(`building_name/no`), 0, 1) AS `user_location_status` FROM `buyers` WHERE `user_ID` = :user_ID";

        $result = Database::executeQuery($query, $fields);
        if ($result[0]['user_location_status'] == 0) {
            return false;
        }
        return true;
    }

    public function processCheckout(string $userID = ''): int
    {
        $fields = [':user_ID' => $userID];

        if (! $this->userPhoneNumberExists($userID) || ! $this->userLocationExists($userID)) {
            return 0;
        }
        else {
            $query = "SELECT `user_ID` FROM `cartItems` WHERE `user_ID` = :user_ID LIMIT 1";
            if (count(Database::executeQuery($query, $fields)) != 0) {
                $query = "  INSERT INTO `orders` (`orders`.`user_ID`) VALUES (:user_ID);
                            SET @order_ID = LAST_INSERT_ID();
                            INSERT INTO `orderItems` 
                                        (`order_ID`, 
                                        `frame_model`, 
                                        `frame_price`, 
                                        `frame_gender`, 
                                        `frame_description`, 
                                        `frame_color`, 
                                        `frame_quantity`, 
                                        `frame_material`, 
                                        `frame_style`, 
                                        `frame_shape`, 
                                        `frame_nose_pads`, 
                                        `frame_width`, 
                                        `frame_bridge_width`, 
                                        `frame_temple_length`) 
                                SELECT
                                        @order_ID,
                                        `frames`.`model`,
                                        `frames`.`price`,
                                        `frames`.`gender`,
                                        `frames`.`description`,
                                        `frameOptions`.`color`,
                                        `cartItems`.`quantity`,
                                        `frameMaterialOptions`.`frame_material`, 
                                        `frameStyleOptions`.`frame_style`, 
                                        `frameShapeOptions`.`frame_shape`, 
                                        `frameNosePadsOptions`.`frame_nose_pads`, 
                                        `frameOptions`.`frame_width`,
                                        `frameOptions`.`bridge_width`,
                                        `frameOptions`.`temple_length`
                                    FROM
                                        `cartItems`
                                INNER JOIN `frames` ON `frames`.`frame_ID` = `cartItems`.`frame_ID`
                                INNER JOIN `frameOptions` ON `frameOptions`.`frameOption_ID` = `cartItems`.`frameOption_ID`
                                INNER JOIN `frameMaterialOptions` ON `frameMaterialOptions`.`frameMaterialOption_ID` = `frames`.`frameMaterialOption_ID` 
                                INNER JOIN `frameStyleOptions` ON `frameStyleOptions`.`frameStyleOption_ID` = `frames`.`frameStyleOption_ID`
                                INNER JOIN `frameShapeOptions` ON `frameShapeOptions`.`frameShapeOption_ID` = `frames`.`frameShapeOption_ID`
                                INNER JOIN `frameNosePadsOptions` ON `frameNosePadsOptions`.`frameNosePadsOption_ID` = `frames`.`frameNosePadsOption_ID`
                                WHERE `cartItems`.`user_ID` = :user_ID;
                                UPDATE `frameOptions`
                                INNER JOIN `cartItems` ON `cartItems`.`frameOption_ID` = `frameOptions`.`frameOption_ID`
                                SET `frameOptions`.`quantity` = `frameOptions`.`quantity` - `cartItems`.`quantity`
                                WHERE `cartItems`.`frameOption_ID` = `frameOptions`.`frameOption_ID`;
                                DELETE FROM `cartItems` WHERE `user_ID` = :user_ID;";
                if (Database::executeQuery($query, $fields)) {
                    return 1;
                }
            }
            return -1;
        }
    }

    public function fetchBuyerCartDetails(string $userID = ''): array {
        $selectUserCartDetailsQuery = "SELECT 
                                            `cartItems`.`cartItem_ID`,
                                            `cartItems`.`frameOption_ID`,
                                            `cartItems`.`quantity`,
                                            `frames`.`frame_ID`,
                                            `frames`.`model`,
                                            `frames`.`price`,
                                            `frameOptions`.`frame_width`,
                                            `frameOptions`.`color`,
                                            `frameOptions`.`frame_width`,
                                            `frameOptions`.`bridge_width`,
                                            `frameOptions`.`temple_length`,
                                            `frameImages`.`image_url`
                                        FROM
                                            `cartItems`
                                        INNER JOIN `frames`
                                                ON `frames`.`frame_ID` = `cartItems`.`frame_ID`
                                        INNER JOIN `frameOptions`
                                                ON `frameOptions`.`frameOption_ID` = `cartItems`.`frameOption_ID`
                                        INNER JOIN `frameImages`
                                                ON `frameImages`.`frame_ID` = `cartItems`.`frame_ID`
                                                AND `frameImages`.`main_image` = 1
                                        WHERE `cartItems`.`user_ID` = :user_ID;";
        return Database::executeQuery($selectUserCartDetailsQuery, [':user_ID' => $userID]);
    }

    public function handleFrameCartInsertion(string $userID = '', array $requestData = []): array {
        $fields = ['frameID', 'frameOptionID', 'frameQuantity'];
        $errors = [];
        if(! FormInputHandler::arePostKeysPresent($fields)) {
            $errors[] = 'Please try again. An error occurred while processing the data you entered.';
        }
        else {
            $fields = [
                ':userID' => $userID,
                ':frameID' => FormInputHandler::sanitizeInput($requestData['frameID']),
                ':frameOptionID' => FormInputHandler::sanitizeInput($requestData['frameOptionID']),
                ':frameQuantity' => FormInputHandler::sanitizeInput($requestData['frameQuantity']),
            ];
            if ($fields[':frameQuantity'] < 1) {
                $errors[] = 'Please try again. At least 1 frame is required.';
            }
            if (StringValidator::isEmpty($fields[':frameID'])) {
                $errors[] = 'Please try again. An error occurred while processing the data you entered.';
            }
            if (StringValidator::isEmpty($fields[':frameOptionID'])) {
                $errors[] = 'Please Choose a Frame Option.';
            }
            if (count($errors) == 0) {
                $isProductExistsQuery = "SELECT `frameOption_ID`, `frame_ID`, `quantity` FROM `frameOptions` WHERE `frameOption_ID` = :frameOptionID AND `frame_ID` = :frameID";
                $productOptionData = Database::executeQuery($isProductExistsQuery, $fields);
                if (count($productOptionData) == 0) {
                    $errors[] = 'Please try again. The selected frame option is not valid.';
                }
                else {
                    if ($productOptionData[0]['quantity'] == '0') {
                        $errors[] = 'The selected frame option is out of stock.';
                    }
                    else if ($productOptionData[0]['quantity'] < $fields[':frameQuantity']) {
                        $errors[] = 'Please try again. The selected quantity exceeds available stock. The available quantity is ' . $productOptionData[0]['quantity'] . '.';
                    }
                    else {
                        $selectQuantityFromCartQuery = "SELECT `quantity` FROM `cartItems` WHERE `user_ID` = :userID AND `frame_ID` = :frameID AND `frameOption_ID` = :frameOptionID";
                        $productQuantityInCart = Database::executeQuery($selectQuantityFromCartQuery, $fields);
                        if (count($productQuantityInCart) == 0) {
                            $insertInCartQuery = "INSERT INTO `cartItems` (`user_ID`, `frame_ID`, `frameOption_ID`, `quantity`) VALUES (:userID, :frameID, :frameOptionID, :frameQuantity)";
                            if (!Database::executeQuery($insertInCartQuery, $fields)) {
                                $errors[] = 'Failed to add the product to the cart. Please try again.';
                            }
                        } else {
                            $updateCartQuery = "SET @frame_quantity = (SELECT `frameOptions`.`quantity` FROM `frameOptions` WHERE `frameOption_ID` = :frameOptionID);
                                            UPDATE `cartItems` SET `cartItems`.`quantity` = IF((`cartItems`.`quantity` + :frameQuantity) < @frame_quantity, `cartItems`.`quantity` + :frameQuantity, @frame_quantity) WHERE `cartItems`.`user_ID` = :userID AND `cartItems`.`frame_ID` = :frameID AND `cartItems`.`frameOption_ID` = :frameOptionID";
                            if (!Database::executeQuery($updateCartQuery, $fields)) {
                                $errors[] = 'We have updated the product quantity in your cart to the maximum available stock.';
                            }
                        }
                    }
                }
            }
        }
        return $errors;
    }

    public function deleteItemFromCart(string $cartItemID = ''): bool
    {
        return Model::table('cartItems')->where('cartItem_ID', $cartItemID)->delete();
    }

    public function increaseCartItemQuantity(string $cartID = '', string $frameOptionID = ''): bool
    {
        $fields = [':cartID' => $cartID, ':frameOptionID' => $frameOptionID];
        $increaseQuantityQuery = "SET @frame_quantity = (SELECT `frameOptions`.`quantity` FROM `frameOptions` WHERE `frameOption_ID` = :frameOptionID);
                                  UPDATE 
                                        `cartItems` 
                                    SET
                                        `cartItems`.`quantity` =
                                            IF(`cartItems`.`quantity` < @frame_quantity, `cartItems`.`quantity` + 1, IF(`cartItems`.`quantity` > @frame_quantity, @frame_quantity, `cartItems`.`quantity` + 0))
                                  WHERE `cartItems`.`cartItem_ID` = :cartID;";
        return Database::executeQuery($increaseQuantityQuery, $fields);
    }

    public function decreaseCartItemQuantity(string $cartID = '', string $frameOptionID = ''): bool
    {
        $fields = [':cartID' => $cartID, ':frameOptionID' => $frameOptionID];
        $decreaseQuantityQuery = "SET @frame_quantity = (SELECT `frameOptions`.`quantity` FROM `frameOptions` WHERE `frameOption_ID` = :frameOptionID);
                                  UPDATE 
                                        `cartItems` 
                                    SET
                                        `cartItems`.`quantity` =
                                            IF(`cartItems`.`quantity` > 1, IF(`cartItems`.`quantity` > @frame_quantity, @frame_quantity, `cartItems`.`quantity` - 1), 1)
                                  WHERE `cartItems`.`cartItem_ID` = :cartID;";
        return Database::executeQuery($decreaseQuantityQuery, $fields);
    }

    public function fetchBuyerCartItemCount(string $userID = ''): mixed
    {
        $selectTotalItemsInUserCart = "SELECT SUM(`quantity`) AS `quantity` FROM `cartItems` WHERE `user_ID` = :user_ID;";
        return Database::executeQuery($selectTotalItemsInUserCart, [':user_ID' => $userID])[0]['quantity'] ?? 0;
    }

    public function fetchWishlistItems(string $userID = ''): array
    {
        $selectWishlistItemsQuery = "SELECT
                        `wishlistItems`.`wishlistItem_ID`,
                        `frames`.`frame_ID`, 
                        `frames`.`model`,
                        `frames`.`price`,
                        `frameMaterialOptions`.`frame_material`, 
                        `frameStyleOptions`.`frame_style`, 
                        `frameShapeOptions`.`frame_shape`, 
                        `frameImages`.`image_url`
                    FROM 
                        `wishlistItems` 
                    INNER JOIN `frames`
                        ON `frames`.`frame_ID` = `wishlistItems`.`frame_ID`
                    INNER JOIN `frameMaterialOptions` 
                        ON `frameMaterialOptions`.`frameMaterialOption_ID` = `frames`.`frameMaterialOption_ID`
                    INNER JOIN `frameStyleOptions` 
                        ON `frameStyleOptions`.`frameStyleOption_ID` = `frames`.`frameStyleOption_ID`
                    INNER JOIN `frameShapeOptions` 
                        ON `frameShapeOptions`.`frameShapeOption_ID` = `frames`.`frameShapeOption_ID`
                    INNER JOIN `frameImages`
                        ON `frameImages`.`frame_ID` = `wishlistItems`.`frame_ID` AND `frameImages`.`main_image` = 1
                    WHERE `wishlistItems`.`user_ID` = :user_ID";
        return Database::executeQuery($selectWishlistItemsQuery, [':user_ID' => $userID]);
    }

    public function toggleWishlistItem(string $userID = '', string $frameID = ''): bool
    {
        $fields = [':user_ID' => $userID, ':frame_ID' => $frameID];
        $isExistsProductInWishlistQuery = "SELECT `user_id` , `frame_ID` FROM `wishlistItems` WHERE `user_id` = :user_ID AND `frame_ID` = :frame_ID";
        $result = Database::executeQuery($isExistsProductInWishlistQuery, $fields);
        if (count($result) == 0) {
            $insertProductInWishlistQuery = "INSERT INTO `wishlistItems` (`user_id`, `frame_ID`) VALUES (:user_ID, :frame_ID)";
            Database::executeQuery($insertProductInWishlistQuery, $fields);
            return true;
        }
        else {
            $deleteProductFromWishlistQuery = "DELETE FROM `wishlistItems` WHERE `user_id` = :user_ID AND `frame_ID` = :frame_ID";
            Database::executeQuery($deleteProductFromWishlistQuery, $fields);
            return false;
        }
    }

    public function fetchBuyerOrders(string $userID = '') : array {
        $fields = [':user_ID' => $userID];
        $query = "SELECT 
                        `orders`.*, 
                        SUM(`orderItems`.`frame_quantity`) AS `order_quantity`, 
                        SUM(`orderItems`.`frame_price` * `orderItems`.`frame_quantity`) AS `total_price` 
                    FROM `orders` 
                    INNER JOIN `orderItems` ON `orderItems`.`order_ID` = `orders`.`order_ID` 
                    WHERE `orders`.`user_ID` = :user_ID
                    GROUP BY `orders`.`order_ID`";
        return Database::executeQuery($query, $fields);
    }

    public function fetchProfile(string $userID = ''): array {
        $fields = [':user_ID' => $userID];
        $selectUserDataAndOrders = "SELECT * FROM `users` INNER JOIN `buyers` ON `buyers`.`user_ID` = `users`.`user_ID`WHERE `users`.`user_ID` = :user_ID;";
        return Database::executeQuery($selectUserDataAndOrders, $fields);
    }

    public function updateProfile(string $userID = '', array $requestData = [], array $fileData = []): array
    {
        $fields = [
            'firstName', 'lastName', 'birthDate', 'gender', 'email',
            'oldPassword', 'newPassword', 'confirmPassword', 'phoneNumber',
            'streetAddress', 'city', 'nearestLandMark', 'buildingName'];
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
                ':phoneNumber' => FormInputHandler::sanitizeInput($requestData['phoneNumber']),
                ':streetAddress' => FormInputHandler::sanitizeInput($requestData['streetAddress']),
                ':city' => FormInputHandler::sanitizeInput($requestData['city']),
                ':nearestLandMark' => FormInputHandler::sanitizeInput($requestData['nearestLandMark']),
                ':buildingName' => FormInputHandler::sanitizeInput($requestData['buildingName']),
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
                $this->validatePhoneNumber($fields[':phoneNumber']),
            );
            if ($this->isEmailTakenByAnotherUser($fields[':email'], $fields[':userID'])) {
                $errors[] = 'This email is already registered.';
            }
            $fields[':oldPassword'] = FormInputHandler::sanitizeInput($requestData['oldPassword']);
            $fields[':newPassword'] = FormInputHandler::sanitizeInput($requestData['newPassword']);
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
            $this->location = new Location($fields[':streetAddress'], $fields[':city'], $fields[':nearestLandMark'], $fields[':buildingName']);
            $errors = array_merge(
                $errors,
                $this->location->validateLocation($this->location),
            );
            if (empty($fileData['userImage']['name'])) {
                $fields[':userImage'] = null;
            }
            else {
                $imageErrors = $this->validateProfileImage($fileData['userImage']);
                if (count($imageErrors) > 0) {
                    $errors = array_merge($errors, $imageErrors);
                }
                else {
                    $fileExtension  = pathinfo($fileData['userImage']['name'], PATHINFO_EXTENSION);
                    $imageName = RandomString::generateAlphanumericString(100) . '.' . $fileExtension;
                    $fields[':userImage'] = $imageName;
                }
            }
            if (count($errors) == 0) {
                $selectImageUserQuery = "SELECT `image_url` FROM `buyers` WHERE `user_ID` = :userID;";
                $imageResult = Database::executeQuery($selectImageUserQuery, $fields);
                $UpdateUserDataAndBuyerDataQuery = "UPDATE
                                                            `users`
                                                    INNER JOIN
                                                            `buyers`
                                                    ON
                                                            `users`.`user_ID` = `buyers`.`user_ID`
                                                    SET
                                                            `first_name` = :firstName,
                                                            `last_name` = :lastName,
                                                            `email` = :email,
                                                            `password` = :newPassword,
                                                            `birth_date` = :birthDate,
                                                            `gender` = :gender,
                                                            `image_url` = IF(ISNULL(:userImage), `image_url`, :userImage),
                                                            `phone_number` = :phoneNumber,
                                                            `street_name` = :streetAddress,
                                                            `city` = :city,
                                                            `nearest_landmark` = :nearestLandMark,
                                                            `building_name/no` = :buildingName
                                                    WHERE
                                                        `users`.`user_ID` = :userID;";
                $updateResult = Database::executeQuery($UpdateUserDataAndBuyerDataQuery, $fields);
                if (! $updateResult) {
                    $errors[] = 'Unable to update user information.';
                }
                else {
                    if ($imageResult[0]['image_url'] != null && $fields[':userImage'] != null) {
                        if (FileUploadValidator::moveFile($fileData['userImage']['tmp_name'], UPLOAD_IMAGES, $fields[':userImage'])) {
                            FileUploadValidator::removeFile(UPLOAD_IMAGES, $imageResult[0]['image_url']);
                        }
                        else {
                            $errors[] = 'All your data has been updated successfully, but there was an issue updating your photo. Please try again later.';
                        }
                    }
                    else {
                        if ($fields[':userImage'] != null) {
                            if (! FileUploadValidator::moveFile($fileData['userImage']['tmp_name'], UPLOAD_IMAGES, $fields[':userImage'])) {
                                $errors[] = 'All your data has been updated successfully, but there was an issue updating your photo. Please try again later.';
                            }
                        }
                    }
                }
            }
        }
        return $errors;
    }

    public function EvaluateFrame(string $userID = '', string $frameID = '', string $rate = '') : bool {
        $rate = (int)$rate;
        if (is_numeric($rate) && $rate >= 0 && $rate <= 5) {
            if (Model::table('framesEvaluation')->where('user_ID', $userID)->where('frame_ID', $frameID)->count() == 1) {
                $query = "UPDATE `framesEvaluation` SET `evaluation` = IF(`evaluation` = :rate, 0, :rate) WHERE `user_ID` = :userID AND `frame_ID` = :frameID";
                return Database::executeQuery($query, [':userID' => $userID, ':frameID' => $frameID, ':rate' => $rate]);
            }
            else {
                $query = "INSERT INTO `framesEvaluation`(`frame_ID`, `user_ID`, `evaluation`) VALUES (:frameID, :userID, :rate)";
                return Database::executeQuery($query, [':userID' => $userID, ':frameID' => $frameID, ':rate' => $rate]);
            }
        }
        return false;
    }

    public function fetchUserRatingForTheFrame(string $userID = '', string $frameID = '') : int {
        $data = Model::table('framesEvaluation')->select('evaluation')->where('user_ID', $userID)->where('frame_ID', $frameID)->get();
        if (count($data) > 0) {
            return $data[0]['evaluation'];
        }
        return 0;
    }

    public function sendComment(string $userID = '', string $frameID = '', array $requestData = []) : array {
        $fields = ['comment'];
        $errors = [];
        if(FormInputHandler::arePostKeysPresent($fields)) {
            $fields = [
                ':userID' => $userID,
                ':frameID' => $frameID,
                ':comment' => FormInputHandler::sanitizeInput($requestData['comment']),
            ];
            foreach ($fields as $field) {
                if (StringValidator::isEmpty($field)) {
                    $errors[] = 'All fields are required, please do not leave them blank.';
                    break;
                }
            }
            if (strlen($fields[':comment']) <= 3) {
                $errors[] = 'Comment must be between 4 and 100 characters.';
            }
            if (count($errors) == 0) {
                $query = "INSERT INTO `comments`(`frame_ID`, `user_ID`, `comment`) VALUES (:frameID, :userID, :comment)";
                if (! Database::executeQuery($query, $fields)) {
                    $errors[] = 'Please try again. An error occurred while send comment.';
                }
            }
        }
        else {
            $errors[] = 'Please try again. An error occurred while processing the data you entered.';
        }
        return $errors;
    }
}