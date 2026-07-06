<?php

namespace App\Support;

use PDO;

class Database
{
    private static ?PDO $connection = null;

    public static function getConnection(): PDO
    {
        if (self::$connection === null) {

            $config = require __DIR__ . '/../../config/database.php';

            self::ensureDatabaseExists($config);

            self::$connection = new PDO(

                "mysql:host={$config['host']};port={$config['port']};dbname={$config['database']};charset={$config['charset']}",

                $config['username'],

                $config['password']

            );

            self::$connection->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );

            self::$connection->setAttribute(
                PDO::ATTR_DEFAULT_FETCH_MODE,
                PDO::FETCH_ASSOC
            );

            self::$connection->setAttribute(
                PDO::ATTR_EMULATE_PREPARES,
                false
            );

            Migration::run(self::$connection);

            Seeder::run(self::$connection);
        }

        return self::$connection;
    }

    private static function ensureDatabaseExists(array $config): void
    {
        $pdo = new PDO(

            "mysql:host={$config['host']};port={$config['port']}",

            $config['username'],

            $config['password']

        );

        $pdo->exec(
            "CREATE DATABASE IF NOT EXISTS `{$config['database']}`
             CHARACTER SET utf8mb4
             COLLATE utf8mb4_unicode_ci"
        );
    }
}