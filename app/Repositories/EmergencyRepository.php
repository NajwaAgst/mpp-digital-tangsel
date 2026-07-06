<?php

namespace App\Repositories;

use App\Support\Database;
use PDO;

class EmergencyRepository
{
    public static function categories(): array
    {
        return [
            "Kebakaran",
            "Kecelakaan",
            "Banjir",
            "Kriminal",
            "Kesehatan",
            "Gempa",
            "Lainnya"
        ];
    }

    public static function create(array $data): int
    {
        $pdo = Database::getConnection();

        $stmt = $pdo->prepare("
            INSERT INTO emergencies
            (
                nama,
                nik,
                phone,
                alamat,
                emergency_type,
                location,
                description,
                latitude,
                longitude,
                status,
                created_at
            )
            VALUES
            (
                :nama,
                :nik,
                :phone,
                :alamat,
                :emergency_type,
                :location,
                :description,
                :latitude,
                :longitude,
                'Menunggu',
                NOW()
            )
        ");

        $stmt->execute([

            ':nama'            => $data['nama'],
            ':nik'             => $data['nik'],
            ':phone'           => $data['phone'],
            ':alamat'          => $data['alamat'],
            ':emergency_type'  => $data['emergency_type'],
            ':location'        => $data['location'],
            ':description'     => $data['description'],
            ':latitude'        => $data['latitude'] ?: null,
            ':longitude'       => $data['longitude'] ?: null,

        ]);

        return (int)$pdo->lastInsertId();
    }

    public static function all(): array
    {
        $stmt = Database::getConnection()->query("
            SELECT *
            FROM emergencies
            ORDER BY created_at DESC
        ");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find(int $id): ?array
    {
        $stmt = Database::getConnection()->prepare("
            SELECT *
            FROM emergencies
            WHERE id=?
            LIMIT 1
        ");

        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public static function updateStatus(int $id, string $status): bool
    {
        $stmt = Database::getConnection()->prepare("
            UPDATE emergencies
            SET status=?
            WHERE id=?
        ");

        return $stmt->execute([$status,$id]);
    }

    public static function delete(int $id): bool
    {
        $stmt = Database::getConnection()->prepare("
            DELETE FROM emergencies
            WHERE id=?
        ");

        return $stmt->execute([$id]);
    }

    public static function count(): int
    {
        return (int) Database::getConnection()
            ->query("SELECT COUNT(*) FROM emergencies")
            ->fetchColumn();
    }

    public static function countByStatus(string $status): int
    {
        $stmt = Database::getConnection()->prepare("
            SELECT COUNT(*)
            FROM emergencies
            WHERE status=?
        ");

        $stmt->execute([$status]);

        return (int)$stmt->fetchColumn();
    }

    public static function chart(): array
    {
        $stmt = Database::getConnection()->query("
            SELECT
                emergency_type,
                COUNT(*) total
            FROM emergencies
            GROUP BY emergency_type
            ORDER BY total DESC
        ");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function statusChart(): array
    {
        $stmt = Database::getConnection()->query("
            SELECT
                status,
                COUNT(*) total
            FROM emergencies
            GROUP BY status
        ");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function latest(int $limit=5): array
    {
        $stmt = Database::getConnection()->prepare("
            SELECT *
            FROM emergencies
            ORDER BY created_at DESC
            LIMIT :limit
        ");

        $stmt->bindValue(":limit",$limit,PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getByNik(string $nik): array
{
    $stmt = Database::getConnection()->prepare("
        SELECT *
        FROM emergencies
        WHERE nik = ?
        ORDER BY created_at DESC
    ");

    $stmt->execute([$nik]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public static function getById(int $id): ?array
{
    $stmt = Database::getConnection()->prepare("
        SELECT *
        FROM emergencies
        WHERE id=?
        LIMIT 1
    ");

    $stmt->execute([$id]);

    return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
}
}