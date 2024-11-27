<?php

namespace App;

use PDO;

class Connection {

    public static function getPDO(): PDO {

        try {
            // Connect to the SQLite Database.

            $driver = 'sqlite';
            $db = dirname(__DIR__) . DIRECTORY_SEPARATOR .'blog.db';

            $host = $driver . ':' . $db;
            
            return new PDO($host, null, null, [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);

        } catch(\Exception $e) {
            die('connection_unsuccessful: ' . $e->getMessage());
        }
    }
}