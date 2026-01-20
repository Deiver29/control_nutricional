<?php

class Database {
    private static $host = "localhost";
    private static $db   = "control_nutricional";
    private static $user = "root";
    private static $pass = "";
    private static $conn = null;

    public static function connect() {
        if (self::$conn === null) {
            try {
                self::$conn = new PDO(
                    "mysql:host=" . self::$host . ";dbname=" . self::$db . ";charset=utf8mb4",
                    self::$user,
                    self::$pass
                );
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Error DB: " . $e->getMessage());
            }
        }
        return self::$conn;
    }
}
