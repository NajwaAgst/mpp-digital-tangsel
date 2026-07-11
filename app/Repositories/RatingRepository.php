<?php

namespace App\Repositories;

use App\Support\Database;
use PDO;

class RatingRepository
{
    public static function create(array $data): bool
    {
        $pdo = Database::getConnection();

        $stmt = $pdo->prepare("
            INSERT INTO ratings
            (
                application_id,
                service_slug,
                service_name,
                nik,
                nama,
                rating,
                comment
            )
            VALUES
            (
                ?,
                ?,
                ?,
                ?,
                ?,
                ?,
                ?
            )
        ");

        return $stmt->execute([

            $data["application_id"],

            $data["service_slug"],

            $data["service_name"],

            $data["nik"],

            $data["nama"],

            $data["rating"],

            $data["comment"]

        ]);
    }

    public static function alreadyRated(int $applicationId): bool
    {
        $pdo = Database::getConnection();

        $stmt = $pdo->prepare("
            SELECT COUNT(*)
            FROM ratings
            WHERE application_id=?
        ");

        $stmt->execute([$applicationId]);

        return $stmt->fetchColumn() > 0;
    }

    public static function all(): array
    {
        $pdo = Database::getConnection();

        return $pdo
            ->query("
                SELECT *
                FROM ratings
                ORDER BY created_at DESC
            ")
            ->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function summary()
    {
        $pdo = Database::getConnection();

        return $pdo
            ->query("
                SELECT

                    service_name,

                    ROUND(AVG(rating),2) avg_rating,

                    COUNT(*) total

                FROM ratings

                GROUP BY service_name

                ORDER BY avg_rating DESC
            ")
            ->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function findByApplication(int $applicationId): ?array
{
    $pdo = Database::getConnection();

    $stmt = $pdo->prepare("
        SELECT *
        FROM ratings
        WHERE application_id=?
        LIMIT 1
    ");

    $stmt->execute([$applicationId]);

    $rating = $stmt->fetch(PDO::FETCH_ASSOC);

    return $rating ?: null;
}
}