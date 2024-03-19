<?php

namespace App\Core;

use \PDO;
use \PDOException;

class Connect
{
    private static $host;
    private static $dbname;
    private static $username;
    private static $password;

    private static $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_CASE => PDO::CASE_NATURAL
    ];

    private static $instance;

    /**
     * @return PDO
     */
    public static function getInstance(): PDO
    {
        if (empty(self::$instance)) {
            self::$host = DB_HOST;
            self::$dbname = DB_DATABASE;
            self::$username = DB_USERNAME;
            self::$password = DB_PASSWORD;

            try {
                self::$instance = new PDO(
                    "mysql:host=" . self::$host . ";dbname=" . self::$dbname . ";charset=utf8mb4",
                    self::$username,
                    self::$password,
                    self::$options
                );
            } catch (PDOException $e) {
                die('ERROR: ' . $e->getMessage());
            }
        }

        return self::$instance;
    }

    final private function __construct()
    {
    }
}
