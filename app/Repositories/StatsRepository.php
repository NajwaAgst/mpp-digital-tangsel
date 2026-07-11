<?php

namespace App\Repositories;

use App\Support\Database;
use PDO;

class StatsRepository
{
    /**
     * Mengambil data statistik ril dari database
     */
    public static function all(): array
    {
        $pdo = Database::getConnection();

        // 1. Hitung total seluruh pengajuan berkas
        $stmtApp = $pdo->query("SELECT COUNT(*) FROM applications");
        $totalApplications = (int) $stmtApp->fetchColumn();

        // 2. Hitung total user/masyarakat yang mendaftar
        $stmtUser = $pdo->query("SELECT COUNT(*) FROM users");
        $totalUsers = (int) $stmtUser->fetchColumn();

        return [
            'services'     => 8, // Tetap hardcode jika jumlah instansi/layanan murni static
            'applications' => number_format($totalApplications, 0, ',', '.'),
            'users'        => number_format($totalUsers, 0, ',', '.'),
            'emergency'    => '24 Jam'
        ];
    }
}