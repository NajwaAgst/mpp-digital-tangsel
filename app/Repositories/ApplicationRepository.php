<?php

namespace App\Repositories;

use App\Support\Database;
use PDO;

class ApplicationRepository
{
    /**
     * ==========================================
     * Buat Pengajuan Baru
     * ==========================================
     */
    public static function create(
        string $slug,
        string $serviceName,
        array $data,
        ?array $user = null
    ): int {

        $pdo = Database::getConnection();

        $stmt = $pdo->prepare("
            INSERT INTO applications
            (
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
            VALUES
            (
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
            )
        ");

        $stmt->execute([

            'service_slug'    => $slug,

            'service_name'    => $serviceName,

            'nama'            => $data['nama'] ?? '',

            'nik'             => $data['nik'] ?? '',

            'hp'              => $data['hp'] ?? '',

            'alamat'          => $data['alamat'] ?? '',

            'application_data'=> json_encode(
                                    $data,
                                    JSON_UNESCAPED_UNICODE
                                ),

            'keterangan'      => $data['keterangan'] ?? '',

            'user_name'       => $user['name'] ?? null,

            'user_email'      => $user['email'] ?? null,

            'status'          => 'Pending',

            'created_at'      => date('Y-m-d H:i:s')

        ]);

        return (int)$pdo->lastInsertId();
    }

    /**
     * ==========================================
     * Semua Pengajuan
     * ==========================================
     */
    public static function all(): array
    {
        $stmt = Database::getConnection()->query("
            SELECT *
            FROM applications
            ORDER BY created_at DESC
        ");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * ==========================================
     * Detail Pengajuan
     * ==========================================
     */
    public static function find(int $id): ?array
    {
        $stmt = Database::getConnection()->prepare("
            SELECT *
            FROM applications
            WHERE id=:id
            LIMIT 1
        ");

        $stmt->execute([
            'id' => $id
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    /**
     * ==========================================
     * Update Status
     * ==========================================
     */
    public static function updateStatus(
        int $id,
        string $status
    ): bool {

        $stmt = Database::getConnection()->prepare("
            UPDATE applications
            SET status=:status
            WHERE id=:id
        ");

        return $stmt->execute([

            'status' => $status,

            'id'     => $id

        ]);
    }

    /**
     * ==========================================
     * Hapus
     * ==========================================
     */
    public static function delete(int $id): bool
    {
        $stmt = Database::getConnection()->prepare("
            DELETE FROM applications
            WHERE id=:id
        ");

        return $stmt->execute([
            'id' => $id
        ]);
    }

    /**
     * ==========================================
     * Riwayat Berdasarkan NIK
     * ==========================================
     */
    public static function byNik(string $nik): array
    {
        $stmt = Database::getConnection()->prepare("
            SELECT *
            FROM applications
            WHERE nik=?
            ORDER BY created_at DESC
        ");

        $stmt->execute([$nik]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * ==========================================
     * Detail User
     * ==========================================
     */
    public static function findByUser(
        int $id,
        string $nik
    ): ?array {

        $stmt = Database::getConnection()->prepare("
            SELECT *
            FROM applications
            WHERE id=?
            AND nik=?
            LIMIT 1
        ");

        $stmt->execute([
            $id,
            $nik
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    /**
     * ==========================================
     * Total Pengajuan User
     * ==========================================
     */
    public static function countByNik(string $nik): int
    {
        $stmt = Database::getConnection()->prepare("
            SELECT COUNT(*)
            FROM applications
            WHERE nik=?
        ");

        $stmt->execute([$nik]);

        return (int)$stmt->fetchColumn();
    }

    /**
     * ==========================================
     * Total Berdasarkan Status
     * ==========================================
     */
    public static function countByNikAndStatus(
        string $nik,
        string $status
    ): int {

        $stmt = Database::getConnection()->prepare("
            SELECT COUNT(*)
            FROM applications
            WHERE nik=?
            AND status=?
        ");

        $stmt->execute([
            $nik,
            $status
        ]);

        return (int)$stmt->fetchColumn();
    }

    /**
     * ==========================================
     * Pengajuan Terbaru User
     * ==========================================
     */
    public static function latestByNik(
        string $nik,
        int $limit = 5
    ): array {

        $stmt = Database::getConnection()->prepare("
            SELECT *
            FROM applications
            WHERE nik=?
            ORDER BY created_at DESC
            LIMIT :limit
        ");

        $stmt->bindValue(1, $nik);
        $stmt->bindValue(":limit", $limit, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}