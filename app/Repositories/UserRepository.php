<?php

namespace App\Repositories;

use App\Support\Database;

class UserRepository
{
    public static function create(array $data): bool
    {
        $stmt = Database::getConnection()->prepare(

            "INSERT INTO users(

                nik,
                name,
                email,
                password,
                role,
                created_at

            )

            VALUES(

                :nik,
                :name,
                :email,
                :password,
                :role,
                :created_at

            )"

        );

        return $stmt->execute([

            'nik'=>$data['nik'],

            'name'=>$data['name'],

            'email'=>$data['email'],

            'password'=>password_hash(

                $data['password'],

                PASSWORD_DEFAULT

            ),

            'role'=>$data['role'] ?? 'user',

            'created_at'=>date('Y-m-d H:i:s')

        ]);
    }

    public static function findByEmail(string $email): ?array
    {
        $stmt=Database::getConnection()->prepare(

            "SELECT *
             FROM users
             WHERE email=:email
             LIMIT 1"

        );

        $stmt->execute([

            'email'=>$email

        ]);

        return $stmt->fetch() ?: null;
    }

    public static function findByNik(string $nik): ?array
    {
        $stmt=Database::getConnection()->prepare(

            "SELECT *
             FROM users
             WHERE nik=:nik
             LIMIT 1"

        );

        $stmt->execute([

            'nik'=>$nik

        ]);

        return $stmt->fetch() ?: null;
    }

    public static function emailExists(string $email): bool
    {
        return self::findByEmail($email)!=null;
    }

    public static function nikExists(string $nik): bool
    {
        return self::findByNik($nik)!=null;
    }
}