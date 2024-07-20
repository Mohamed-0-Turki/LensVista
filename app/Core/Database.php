<?php

namespace Core;

use PDO;
use PDOException;

final class Database {

    private static mixed $connect = null;

    private function __construct() { }
    public final static function getConnect(): PDO {
        if (self::$connect === null) {
            return self::connect();
        } else {
            return self::$connect;
        }
    }
    private static function connect() : mixed
    {
        $config = array(
            'dsn' => 'mysql:host='.DB_HOST.';dbname='.DB_NAME,
            'user' => DB_USER,
            'password' => DB_PASSWORD,
            'options' => array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8')
        );

        if (self::$connect === null) {
            try {
                $connect = new PDO($config['dsn'], $config['user'], $config['password'], $config['options']);

                $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $connect->setAttribute(PDO::ATTR_CASE, PDO::CASE_NATURAL);

                self::$connect = $connect;
            } catch (PDOException $ex) {
                return 'Failed ' . $ex -> getMessage();
            }
        }
        return self::$connect;
    }
    public final static function executeQuery(string $query = null, array $data = [], string $dataType = 'array'): bool|array
    {
        $connect = self::connect();
        if($query == null) {
            return false;
        } else {
            try {
                $connect->beginTransaction();
                $result = false;
                $returnedData = [];
                $queries = explode(';', trim($query, ';'));

                foreach ($queries as $individualQuery) {
                    $individualQuery = trim($individualQuery);

                    if (! empty($individualQuery)) {
                        $stmt = $connect->prepare($individualQuery);
                        
                        preg_match_all('/:\w+/', $individualQuery, $matches);

                        $queryParams = array_intersect_key($data, array_flip($matches[0]));

                        $stmt->execute($queryParams);

                        if(preg_match("/^\s*(SELECT)\s/i", $individualQuery)) {
                            $returnedData[] =  ($dataType === 'object') ?
                                $stmt->fetchAll(PDO::FETCH_OBJ) :
                                $stmt->fetchAll(PDO::FETCH_ASSOC);
                        } else {
                            $result = $stmt->rowCount() > 0;
                        }
                        $stmt->closeCursor();
                    }
                }
                $connect->commit();
                return (count($returnedData) > 0) ? ((count($returnedData) == 1) ? $returnedData[0] : $returnedData) : $result;
            } catch (PDOException $ex) {
                $connect->rollBack();
                dump('Transaction failed: ' . $ex->getMessage());
                return false;
            }
        }
    }
}
