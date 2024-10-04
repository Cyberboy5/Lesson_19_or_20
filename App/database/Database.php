<?php

namespace App\database;
USE PDO;

class Database {

    private static $host = "localhost";
    private static $db_name = "talaba_db";
    private static $username = "root"; 
    private static  $password = "Cyberboy@5";
    public static $conn;

    public static function getConnection() {
        self::$conn = null;
        try {
            self::$conn = new PDO("mysql:host=" . self::$host . ";dbname=" . self::$db_name, self::$username, self::$password);
            self::$conn->exec("set names utf8");
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return self::$conn;
    }
}


?>
