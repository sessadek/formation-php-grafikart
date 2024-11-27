<?php

namespace App;

use PDO;
use App\Auth;

class App {

    public static $pdo;

    public static $auth;

    public static function getPDO(): PDO
    {
        if(!self::$pdo) {
            $driver = 'sqlite';
            $db = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'data.sqlite';
            if(!file_exists($db)) {
                echo "The database doesn't exists";
            }
            $root = "$driver:$db";
            self::$pdo = new PDO($root, null, null, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        }
        return self::$pdo;
    }

    public static function getAuth(): Auth
    {
        if(!self::$auth) {
            self::$auth = new Auth(self::getPDO(), 'login.php', []);
        }

        return self::$auth;
    }
}