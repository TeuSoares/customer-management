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
            self::setConfigData();

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

    private static function setConfigData(): void
    {
        $database = config('database');

        self::$host = $database['DB_HOST'];
        self::$dbname = $database['DB_DATABASE'];
        self::$username = $database['DB_USERNAME'];
        self::$password = $database['DB_PASSWORD'];
    }

    final private function __construct()
    {
    }
}
