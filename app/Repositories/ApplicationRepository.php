<?php

namespace App\Repositories;

use App\Support\Database;

class ApplicationRepository
{
    public static function create(
        string $slug,
        string $serviceName,
        array $data,
        ?array $user = null
    ): int {

        $pdo = Database::getConnection();

        $stmt = $pdo->prepare(

            "INSERT INTO applications(

                service_slug,
                service_name,
                nama,
                nik,
                hp,
                alamat,
                application_data,
                keterangan,
                user_name,
                user_email,
                status,
                created_at

            )

            VALUES(

                :service_slug,
                :service_name,
                :nama,
                :nik,
                :hp,
                :alamat,
                :application_data,
                :keterangan,
                :user_name,
                :user_email,
                :status,
                :created_at

            )"

        );

        $stmt->execute([

            'service_slug'=>$slug,

            'service_name'=>$serviceName,

            'nama'=>$data['nama'] ?? '',

            'nik'=>$data['nik'] ?? '',

            'hp'=>$data['hp'] ?? '',

            'alamat'=>$data['alamat'] ?? '',

            'application_data'=>json_encode(

                $data,

                JSON_UNESCAPED_UNICODE

            ),

            'keterangan'=>$data['keterangan'] ?? '',

            'user_name'=>$user['name'] ?? null,

            'user_email'=>$user['email'] ?? null,

            'status'=>'Pending',

            'created_at'=>date('Y-m-d H:i:s')

        ]);

        return (int)$pdo->lastInsertId();
    }

    public static function all(): array
    {
        $stmt = Database::getConnection()->query(

            "SELECT *

            FROM applications

            ORDER BY created_at DESC"

        );

        return $stmt->fetchAll();
    }

    public static function find(int $id): ?array
    {
        $stmt = Database::getConnection()->prepare(

            "SELECT *

            FROM applications

            WHERE id=:id

            LIMIT 1"

        );

        $stmt->execute([

            'id'=>$id

        ]);

        return $stmt->fetch() ?: null;
    }

    public static function updateStatus(

        int $id,

        string $status

    ): bool {

        $stmt = Database::getConnection()->prepare(

            "UPDATE applications

            SET status=:status

            WHERE id=:id"

        );

        return $stmt->execute([

            'status'=>$status,

            'id'=>$id

        ]);
    }

    public static function delete(int $id): bool
    {
        $stmt = Database::getConnection()->prepare(

            "DELETE FROM applications

            WHERE id=:id"

        );

        return $stmt->execute([

            'id'=>$id

        ]);
    }

    /**
 * ==========================================
 * Riwayat Pengajuan User
 * ==========================================
 */
public static function historyByUser(string $nik): array
{
    $stmt = Database::getConnection()->prepare("
        SELECT *
        FROM applications
        WHERE nik = ?
        ORDER BY created_at DESC
    ");

    $stmt->execute([$nik]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * ==========================================
 * Detail Pengajuan
 * ==========================================
 */
public static function findByUser(int $id, string $nik): ?array
{
    $stmt = Database::getConnection()->prepare("
        SELECT *
        FROM applications
        WHERE id = ?
        AND nik = ?
        LIMIT 1
    ");

    $stmt->execute([$id, $nik]);

    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    return $data ?: null;
}
}