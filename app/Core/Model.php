<?php

namespace Core;

use Exception;

final class Model
{
    private static string $tableName = '';
    private static string $selectFields = '*';
    private static array $whereClauses = [];
    private static array $orderBy = [];

    private function __construct() {}

    public static function table(string $table = ''): self {
        if (empty($table)) {
            throw new Exception('Table name cannot be empty.');
        } else {
            $query = "SHOW TABLES FROM ". DB_NAME ." LIKE :table";
            $result = Database::executeQuery($query, [':table' => $table]);
            if ($result) {
                self::$tableName = $table;
                return new self;
            } else {
                throw new Exception("Table '$table' does not exist.");
            }
        }
    }

    public static function select(string ...$fields): self {
        self::$selectFields = (count($fields) > 0) ? implode(', ', $fields) : '*';
        return new self;
    }

    public static function where(string $column, int|float|string $value): self {
        self::$whereClauses[] = ['AND', $column, $value];
        return new self;
    }

    public static function orWhere(string $column, int|float|string $value): self {
        self::$whereClauses[] = ['OR', $column, $value];
        return new self;
    }

    public static function orderBy(string $column, string $direction = 'DESC'): self {
        self::$orderBy[] = "$column $direction";
        return new self;
    }

    public static function get(): array {
        if (empty(self::$tableName)) {
            throw new Exception('Table not set.');
        }

        $query = "SELECT " . self::$selectFields . " FROM " . self::$tableName;
        $params = [];

        if (count(self::$whereClauses) > 0) {
            $whereParts = [];
            foreach (self::$whereClauses as $index => [$type, $column, $value]) {
                $param = ":where_$index";
                $whereParts[] = ($index > 0 ? $type : '') . " $column = $param";
                $params[$param] = $value;
            }
            $query .= " WHERE " . implode(" ", $whereParts);
        }

        if (count(self::$orderBy) > 0) {
            $query .= " ORDER BY " . implode(", ", self::$orderBy);
        }

        self::$tableName = "";
        self::$selectFields = "";
        self::$whereClauses = [];
        self::$orderBy = [];

        return Database::executeQuery($query, $params);
    }

    public static function delete() : bool {
        if (empty(self::$tableName)) {
            throw new Exception('Table not set.');
        }

        $query = "DELETE FROM " . self::$tableName;
        $params = [];

        if (count(self::$whereClauses) > 0) {
            $whereParts = [];
            foreach (self::$whereClauses as $index => [$type, $column, $value]) {
                $param = ":where_$index";
                $whereParts[] = ($index > 0 ? $type : '') . " $column = $param";
                $params[$param] = $value;
            }
            $query .= " WHERE " . implode(" ", $whereParts);
        }
        else {
            throw new Exception('where not set.');
        }

        self::$tableName = "";
        self::$whereClauses = [];

        return Database::executeQuery($query, $params);
    }

    public function count() : int {
        if (empty(self::$tableName)) {
            throw new Exception('Table not set.');
        }

        $query = "SELECT COUNT(*) AS `number` FROM " . self::$tableName;
        $params = [];

        if (count(self::$whereClauses) > 0) {
            $whereParts = [];
            foreach (self::$whereClauses as $index => [$type, $column, $value]) {
                $param = ":where_$index";
                $whereParts[] = ($index > 0 ? $type : '') . " $column = $param";
                $params[$param] = $value;
            }
            $query .= " WHERE " . implode(" ", $whereParts);
        }

        self::$tableName = "";
        self::$whereClauses = [];
        return Database::executeQuery($query, $params)[0]['number'];
    }
}