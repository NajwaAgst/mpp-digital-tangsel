<?php

namespace App\Support;

use PDO;

class Migration
{
    public static function run(PDO $pdo): void
    {
        self::createServicesTable($pdo);
        self::createStatsTable($pdo);
        self::createApplicationsTable($pdo);
        self::createEmergencyReportsTable($pdo);
        self::createUsersTable($pdo);
        self::createPenduduksTable($pdo);
        self::createNpwpsTable($pdo);
        self::createNibsTable($pdo);
    }

    /*
    |--------------------------------------------------------------------------
    | SERVICES
    |--------------------------------------------------------------------------
    */

    private static function createServicesTable(PDO $pdo): void
    {
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS services (

                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

                slug VARCHAR(120) UNIQUE NOT NULL,

                name VARCHAR(180) NOT NULL,

                category VARCHAR(120) NOT NULL,

                institution VARCHAR(255) NOT NULL,

                summary TEXT NOT NULL,

                description TEXT NOT NULL,

                duration VARCHAR(120) NOT NULL,

                who TEXT NOT NULL,

                notes TEXT NOT NULL,

                documents LONGTEXT NOT NULL,

                steps LONGTEXT NOT NULL,

                accent VARCHAR(120) NOT NULL

            )

            ENGINE=InnoDB
            DEFAULT CHARSET=utf8mb4
            COLLATE=utf8mb4_unicode_ci
        ");
    }

    /*
    |--------------------------------------------------------------------------
    | STATS
    |--------------------------------------------------------------------------
    */

    private static function createStatsTable(PDO $pdo): void
    {
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS stats (

                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

                label VARCHAR(120) NOT NULL,

                value VARCHAR(80) NOT NULL,

                detail VARCHAR(180) NOT NULL

            )

            ENGINE=InnoDB
            DEFAULT CHARSET=utf8mb4
            COLLATE=utf8mb4_unicode_ci
        ");
    }

    /*
    |--------------------------------------------------------------------------
    | APPLICATIONS (MPP)
    |--------------------------------------------------------------------------
    */

    private static function createApplicationsTable(PDO $pdo): void
    {
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS applications (

                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

                service_slug VARCHAR(120) NOT NULL,

                service_name VARCHAR(180) NOT NULL,

                nama VARCHAR(180) NOT NULL,

                nik VARCHAR(32) NOT NULL,

                hp VARCHAR(32),

                alamat TEXT,

                application_data LONGTEXT,

                keterangan TEXT,

                user_name VARCHAR(180),

                user_email VARCHAR(180),

                status ENUM('Pending','Approved','Rejected')
                DEFAULT 'Pending',

                created_at DATETIME NOT NULL

            )

            ENGINE=InnoDB
            DEFAULT CHARSET=utf8mb4
            COLLATE=utf8mb4_unicode_ci
        ");
    }

    /*
    |--------------------------------------------------------------------------
    | EMERGENCY REPORTS (112)
    |--------------------------------------------------------------------------
    */

    private static function createEmergencyReportsTable(PDO $pdo): void
    {
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS emergency_reports (

                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

                nama VARCHAR(150) NOT NULL,

                nik VARCHAR(20) NOT NULL,

                phone VARCHAR(20),

                emergency_type VARCHAR(100),

                location TEXT,

                description TEXT,

                status VARCHAR(30)
                DEFAULT 'Menunggu',

                created_at DATETIME
                DEFAULT CURRENT_TIMESTAMP

            )

            ENGINE=InnoDB
            DEFAULT CHARSET=utf8mb4
            COLLATE=utf8mb4_unicode_ci
        ");
    }

    /*
    |--------------------------------------------------------------------------
    | USERS
    |--------------------------------------------------------------------------
    */

    private static function createUsersTable(PDO $pdo): void
    {
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS users (

                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

                nik VARCHAR(16) UNIQUE NOT NULL,

                name VARCHAR(150) NOT NULL,

                email VARCHAR(150) UNIQUE NOT NULL,

                password VARCHAR(255) NOT NULL,

                role ENUM('user','admin')
                DEFAULT 'user',

                created_at DATETIME NOT NULL

            )

            ENGINE=InnoDB
            DEFAULT CHARSET=utf8mb4
            COLLATE=utf8mb4_unicode_ci
        ");
    }

    /*
    |--------------------------------------------------------------------------
    | DUKCAPIL
    |--------------------------------------------------------------------------
    */

    private static function createPenduduksTable(PDO $pdo): void
    {
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS penduduks (

                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

                nik VARCHAR(16) UNIQUE NOT NULL,

                nama VARCHAR(150) NOT NULL,

                tempat_lahir VARCHAR(100),

                tanggal_lahir DATE,

                alamat TEXT,

                created_at DATETIME

            )

            ENGINE=InnoDB
            DEFAULT CHARSET=utf8mb4
            COLLATE=utf8mb4_unicode_ci
        ");
    }

    /*
    |--------------------------------------------------------------------------
    | NPWP
    |--------------------------------------------------------------------------
    */

    private static function createNpwpsTable(PDO $pdo): void
    {
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS npwps (

                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

                nik VARCHAR(16) NOT NULL,

                npwp VARCHAR(30) NOT NULL,

                status_npwp VARCHAR(50),

                created_at DATETIME

            )

            ENGINE=InnoDB
            DEFAULT CHARSET=utf8mb4
            COLLATE=utf8mb4_unicode_ci
        ");
    }

    /*
    |--------------------------------------------------------------------------
    | NIB OSS
    |--------------------------------------------------------------------------
    */

    private static function createNibsTable(PDO $pdo): void
    {
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS nibs (

                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

                nik VARCHAR(16) NOT NULL,

                nib VARCHAR(30) NOT NULL,

                nama_usaha VARCHAR(150),

                jenis_usaha VARCHAR(100),

                created_at DATETIME

            )

            ENGINE=InnoDB
            DEFAULT CHARSET=utf8mb4
            COLLATE=utf8mb4_unicode_ci
        ");
    }
}