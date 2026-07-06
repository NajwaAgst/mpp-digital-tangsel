<?php

namespace App\Repositories;

use App\Support\Database;

class CitizenRepository
{
    public static function getCitizenByNik(string $nik): ?array
    {
        $sql = "

            SELECT

                p.nik,

                p.nama,

                p.tempat_lahir,

                p.tanggal_lahir,

                p.alamat,

                n.npwp,

                n.status_npwp,

                b.nib,

                b.nama_usaha,

                b.jenis_usaha

            FROM penduduks p

            LEFT JOIN npwps n

                ON p.nik=n.nik

            LEFT JOIN nibs b

                ON p.nik=b.nik

            WHERE p.nik=:nik

            LIMIT 1

        ";

        $stmt = Database::getConnection()->prepare($sql);

        $stmt->execute([

            'nik'=>$nik

        ]);

        return $stmt->fetch() ?: null;
    }

    public static function findPendudukByNik(
        string $nik
    ): ?array {

        $stmt = Database::getConnection()->prepare(

            "SELECT *

            FROM penduduks

            WHERE nik=:nik

            LIMIT 1"

        );

        $stmt->execute([

            'nik'=>$nik

        ]);

        return $stmt->fetch() ?: null;
    }

    public static function findNpwpByNik(
        string $nik
    ): ?array {

        $stmt = Database::getConnection()->prepare(

            "SELECT *

            FROM npwps

            WHERE nik=:nik

            LIMIT 1"

        );

        $stmt->execute([

            'nik'=>$nik

        ]);

        return $stmt->fetch() ?: null;
    }

    public static function findNibByNik(
        string $nik
    ): ?array {

        $stmt = Database::getConnection()->prepare(

            "SELECT *

            FROM nibs

            WHERE nik=:nik

            LIMIT 1"

        );

        $stmt->execute([

            'nik'=>$nik

        ]);

        return $stmt->fetch() ?: null;
    }
}