<?php

namespace App\Http\Controllers;

use App\Support\Database; // Dibutuhkan agar fungsi Database::getConnection() tidak error
use App\Repositories\ServiceRepository;
use App\Repositories\StatsRepository;
use App\Repositories\EmergencyRepository;
use App\Repositories\ApplicationRepository;
use PDO;

class HomeController extends Controller
{
    public function index(): string
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        /*
        |--------------------------------------------------------------------------
        | User Login
        |--------------------------------------------------------------------------
        */

        $authUser = $_SESSION['user'] ?? null;

        /*
        |--------------------------------------------------------------------------
        | Riwayat Pengajuan User
        |--------------------------------------------------------------------------
        */

        $applications = [];

        if (!empty($authUser['nik'])) {
            $applications = ApplicationRepository::byNik($authUser['nik']);
        }

        /*
        |--------------------------------------------------------------------------
        | Data Layanan
        |--------------------------------------------------------------------------
        */

        $services = array_map(
            static function (array $service): array {
                return [
                    'slug'     => $service['slug'],
                    'name'     => $service['name'],
                    'category' => $service['category'],
                    'summary'  => $service['summary'],
                    'accent'   => $service['accent'] ?? 'emerald',
                ];
            },
            ServiceRepository::all()
        );

        /*
        |--------------------------------------------------------------------------
        | Statistik MPP
        |--------------------------------------------------------------------------
        */

        $stats = StatsRepository::all();

        /*
        |--------------------------------------------------------------------------
        | Statistik Emergency
        |--------------------------------------------------------------------------
        */

        $emergencyStats = [
            'total'      => EmergencyRepository::count(),
            'waiting'    => EmergencyRepository::countByStatus('Menunggu'),
            'processing' => EmergencyRepository::countByStatus('Diproses'),
            'done'       => EmergencyRepository::countByStatus('Selesai'),
        ];

        /*
        |--------------------------------------------------------------------------
        | Portal
        |--------------------------------------------------------------------------
        */

        $portals = [
            [
                'title' => 'MPP Digital',
                'description' => 'Pengajuan seluruh layanan perizinan, administrasi kependudukan, perpajakan, kesehatan, pendidikan, dan layanan publik lainnya secara online.',
                'icon' => '🏛️',
                'color' => 'emerald',
                'url' => '/services',
                'button' => 'Masuk MPP',
                'badge' => 'Pelayanan Publik'
            ],
            [
                'title' => 'Emergency 112',
                'description' => 'Layanan pelaporan keadaan darurat Kota Tangerang Selatan. Digunakan untuk kebakaran, kecelakaan, kriminalitas, bencana alam, maupun kondisi darurat lainnya.',
                'icon' => '🚨',
                'color' => 'red',
                'url' => '/emergency',
                'button' => 'Buka Emergency',
                'badge' => 'Darurat 24 Jam'
            ]
        ];

        /*
        |--------------------------------------------------------------------------
        | Dashboard User
        |--------------------------------------------------------------------------
        */

        $userStats = [
            'total' => count($applications),
            'pending' => count(
                array_filter(
                    $applications,
                    fn($a) => ($a['status'] ?? '') === 'Menunggu'
                )
            ),
            'processing' => count(
                array_filter(
                    $applications,
                    fn($a) => ($a['status'] ?? '') === 'Diproses'
                )
            ),
            'done' => count(
                array_filter(
                    $applications,
                    fn($a) => ($a['status'] ?? '') === 'Selesai'
                )
            ),
            'rejected' => count(
                array_filter(
                    $applications,
                    fn($a) => ($a['status'] ?? '') === 'Ditolak'
                )
            )
        ];

        /*
        |--------------------------------------------------------------------------
        | Statistik Rating & Kepuasan (Koneksi Database)
        |--------------------------------------------------------------------------
        */

        $pdo = Database::getConnection();

        // 1. Ambil Rata-rata Rating Global & Total Penilaian
        $statsGlobal = $pdo->query("
            SELECT 
                COUNT(*) as total_penilaian,
                AVG(rating) as avg_rating,
                SUM(CASE WHEN rating >= 4 THEN 1 ELSE 0 END) as puas_count
            FROM ratings
        ")->fetch(PDO::FETCH_ASSOC);

        $totalPenilaian = $statsGlobal['total_penilaian'] ?? 0;
        $avgRating = round($statsGlobal['avg_rating'] ?? 0, 1);
        $persenPuas = $totalPenilaian > 0 ? round(($statsGlobal['puas_count'] / $totalPenilaian) * 100) : 0;

        // 2. Ambil Rating Per Layanan (untuk bar grafik performa)
        $serviceRatings = $pdo->query("
            SELECT 
                service_name, 
                AVG(rating) as avg_rating, 
                COUNT(*) as total_ulasan
            FROM ratings 
            GROUP BY service_name 
            ORDER BY avg_rating DESC
        ")->fetchAll(PDO::FETCH_ASSOC);

        // 3. Ambil Sebaran Bintang (untuk bar grafik ulasan bintang 1-5)
        $starDistribution = $pdo->query("
            SELECT rating, COUNT(*) as jumlah 
            FROM ratings 
            GROUP BY rating
        ")->fetchAll(PDO::FETCH_KEY_PAIR);

        // Mengisi indeks bintang 1 s.d. 5 dengan nilai default 0 jika belum ada data ulasan
        for ($i = 1; $i <= 5; $i++) {
            if (!isset($starDistribution[$i])) {
                $starDistribution[$i] = 0;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Render View Utama
        |--------------------------------------------------------------------------
        */

        return $this->view(
            'home',
            [
                'authUser'         => $authUser,
                'applications'     => $applications,
                'userStats'        => $userStats,
                'services'         => $services,
                'stats'            => $stats,
                'portals'          => $portals,
                'emergencyStats'   => $emergencyStats,
                
                // Variabel baru untuk penampil Bar Chart di Frontend
                'totalPenilaian'   => $totalPenilaian,
                'avgRating'        => $avgRating,
                'persenPuas'       => $persenPuas,
                'serviceRatings'   => $serviceRatings,
                'starDistribution' => $starDistribution,
            ]
        );
    }
}