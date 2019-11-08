<?php

class Db
{
    /**
     * Connect to database and returns connection
     */
    private static function connect()
    {
        $servername = "localhost";
        $username = "sanja";
        $password = "123456";
        $dbname = "social_network";
        $charset = "utf8mb4";

        try {
            $dsn = "mysql:host=" . $servername . ";dbname=" . $dbname . ";charset=" . $charset;
            $pdo = new PDO($dsn, $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    /**
     * Executes select query and returns true if exists or false
     */
    public static function queryExists($query, $params = array())
    {
        $pdo = self::connect();
        $query = "SELECT EXISTS ($query) as E";
        $statement = $pdo->prepare($query);
        $statement->execute($params);
        $data = $statement->fetchColumn(0);
        return !!$data;
    }

    /**
     * Executes select query and returns all rows
     */
    public static function querySelect($query, $params = array())
    {
        $pdo = self::connect();
        $statement = $pdo->prepare($query);
        $statement->execute($params);
        $data = $statement->fetchAll();
        return $data;
    }

    /**
     * Executes insert query and returns the inserted id
     */
    public static function queryInsert($query, $params = array())
    {
        $pdo = self::connect();
        $statement = $pdo->prepare($query);
        $statement->execute($params);
        $id = $pdo->lastInsertId();
        return $id;
    }

    /**
     * Executes update query and returns the number of affected rows
     */
    public static function queryUpdate($query, $params = array())
    {
        $pdo = self::connect();
        $statement = $pdo->prepare($query);
        $statement->execute($params);
        $affectedRows = $statement->rowCount();
        return $affectedRows;
    }

    /**
     * Executes delete query and returns the number of deleted rows
     */
    public static function queryDelete($query, $params = array())
    {
        $pdo = self::connect();
        $statement = $pdo->prepare($query);
        $statement->execute($params);
        $affectedRows = $statement->rowCount();
        return $affectedRows;
    }
}
