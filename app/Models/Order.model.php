<?php

namespace Models;

use Core\Database;
use Core\Model;
use Helpers\FormInputHandler;
use Helpers\NumberValidator;
use Helpers\StringValidator;

class Order
{
    public function fetchBuyerOrders(string $userID = ''): array
    {
        $fields = [':user_ID' => $userID];
        $selectBuyerOrders = "SELECT 
                                        `orders`.*, 
                                        SUM(`orderItems`.`frame_quantity`) AS `order_quantity`, 
                                        SUM(`orderItems`.`frame_price` * `orderItems`.`frame_quantity`) AS `total_price` 
                                  FROM `orders` 
                                  INNER JOIN `orderItems` ON `orderItems`.`order_ID` = `orders`.`order_ID` 
                                  WHERE `orders`.`user_ID` = :user_ID
                                  GROUP BY `orders`.`order_ID`";
        $data = Database::executeQuery($selectBuyerOrders, $fields);
        return [
            'orders' => $data,
        ];
    }
    public function fetchOrderDetails(string $orderID = ''): array
    {
        $fields = [
            ':orderID' => $orderID
        ];
        $selectOrderAndOrderItemsQuery = "SELECT `orders`.* , SUM(`orderItems`.`frame_price` * `orderItems`.`frame_quantity`) AS `total_price` FROM `orders` 
                  INNER JOIN `orderItems` ON `orderItems`.`order_ID` = `orders`.`order_ID` WHERE `orders`.`order_ID` = :orderID;
                  SELECT * FROM `orderItems` WHERE `order_ID` = :orderID;";
        $data = Database::executeQuery($selectOrderAndOrderItemsQuery, $fields);
        return [
            'order' => $data[0][0],
            'orderItems' => $data[1]
        ];
    }

    public function fetchOrderAndBuyerDetails(string $orderID = ''): array
    {
        $query = "SELECT 
                        `orders`.`order_ID`, 
                        `orders`.`order_status`, 
                        `orders`.`payment_status`, 
                        `orders`.`order_phase`, 
                        `buyers`.`buyer_ID`, 
                        `buyers`.`phone_number`, 
                        `buyers`.`street_name`, 
                        `buyers`.`city`, 
                        `buyers`.`nearest_landmark`, 
                        `buyers`.`building_name/no`, 
                        CONCAT(`users`.`first_name`, ' ', `users`.`last_name`) AS `user_name`
                    FROM 
                        `orders` 
                    INNER JOIN `buyers` ON `buyers`.`user_ID` = `orders`.`user_ID` 
                    INNER JOIN `users` ON `users`.`user_ID` = `orders`.`user_ID` 
                    WHERE `orders`.`order_ID` = :orderID;";
        $data = Database::executeQuery($query, [':orderID' => $orderID]);
        if(count($data) > 0) {
            return $data[0];
        }
        return $data;
    }

    public function fetchNumberOfOrders(): int {
        return Model::table('orders')->count();
    }
    public function fetchNumberOfOrdersInLastDay(): int
    {
        $query = "SELECT COUNT(`order_ID`) AS `order_count` FROM `orders` WHERE create_date >= NOW() - INTERVAL 1 DAY;";
        return Database::executeQuery($query)[0]['order_count'];
    }

    public function fetchDetailsOfOrdersInLastDay(): array
    {
        $query = "SELECT `orders`.*, SUM(`orderItems`.`frame_quantity`) AS `order_quantity`, SUM(`orderItems`.`frame_price` * `orderItems`.`frame_quantity`) AS `total_price` 
                    FROM `orders` 
                    INNER JOIN `orderItems` ON `orderItems`.`order_ID` = `orders`.`order_ID` 
                    WHERE `orders`.`create_date` >= NOW() - INTERVAL 1 DAY
                    GROUP BY `orders`.`order_ID`";
        return Database::executeQuery($query);
    }
    public function fetchDetailsOfOrders(): array
    {
        $query = "SELECT `orders`.*, SUM(`orderItems`.`frame_quantity`) AS `order_quantity`, SUM(`orderItems`.`frame_price` * `orderItems`.`frame_quantity`) AS `total_price` 
                    FROM `orders` 
                    INNER JOIN `orderItems` ON `orderItems`.`order_ID` = `orders`.`order_ID` 
                    GROUP BY `orders`.`order_ID`";
        return Database::executeQuery($query);
    }
}