<?php

namespace Libraries;

use Core\Database;

class Authentication
{
    public function __construct() {
        if(isset($_COOKIE['TOKEN'])) {
            if(! isset($_SESSION['USER'])) {
                $query = "SELECT `users`.`user_ID`, `users`.`user_role` FROM `authentications` INNER JOIN `users` ON `users`.`user_ID` = `authentications`.`user_ID` WHERE `token` = :token";
                $data = Database::executeQuery($query, [':token' => $_COOKIE['TOKEN']]);
                if (count($data) > 0) {
                    $_SESSION['USER']['userID'] = $data[0]['user_ID'];
                    $_SESSION['USER']['role'] = $data[0]['user_role'];
                }
            }
        }
    }
}