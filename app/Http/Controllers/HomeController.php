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
| Statistik Rating & Kepuasan (MPP + Emergency)
|--------------------------------------------------------------------------
*/

$pdo = Database::getConnection();

/*
|--------------------------------------------------------------------------
| Statistik MPP
|--------------------------------------------------------------------------
*/

$mppStats = $pdo->query("
    SELECT
        COUNT(*) AS total,
        AVG(rating) AS avg_rating,
        SUM(CASE WHEN rating >= 4 THEN 1 ELSE 0 END) AS puas
    FROM ratings
")->fetch(PDO::FETCH_ASSOC);

/*
|--------------------------------------------------------------------------
| Statistik Emergency
|--------------------------------------------------------------------------
*/

$emergencyRatingStats = $pdo->query("
    SELECT
        COUNT(*) AS total,
        AVG(rating) AS avg_rating,
        SUM(CASE WHEN rating >= 4 THEN 1 ELSE 0 END) AS puas
    FROM emergencies
    WHERE rating IS NOT NULL
")->fetch(PDO::FETCH_ASSOC);

/*
|--------------------------------------------------------------------------
| Gabungkan Statistik
|--------------------------------------------------------------------------
*/

$mppTotal = (int)($mppStats["total"] ?? 0);
$emergencyTotal = (int)($emergencyRatingStats["total"] ?? 0);

$totalPenilaian = $mppTotal + $emergencyTotal;

$totalScore =
    (($mppStats["avg_rating"] ?? 0) * $mppTotal)
    +
    (($emergencyRatingStats["avg_rating"] ?? 0) * $emergencyTotal);

$avgRating = $totalPenilaian > 0
    ? round($totalScore / $totalPenilaian, 1)
    : 0;

$totalPuas =
    (int)($mppStats["puas"] ?? 0)
    +
    (int)($emergencyRatingStats["puas"] ?? 0);

$persenPuas = $totalPenilaian > 0
    ? round(($totalPuas / $totalPenilaian) * 100)
    : 0;

/*
|--------------------------------------------------------------------------
| Rating Per Layanan MPP
|--------------------------------------------------------------------------
*/

$mppServices = $pdo->query("
    SELECT
        service_name,
        ROUND(AVG(rating),1) AS avg_rating,
        COUNT(*) AS total_ulasan
    FROM ratings
    GROUP BY service_name
")->fetchAll(PDO::FETCH_ASSOC);

/*
|--------------------------------------------------------------------------
| Rating Emergency (digabung jadi 1 layanan)
|--------------------------------------------------------------------------
*/

$emergencyService = $pdo->query("
    SELECT
        'Emergency 112' AS service_name,
        ROUND(AVG(rating),1) AS avg_rating,
        COUNT(*) AS total_ulasan
    FROM emergencies
    WHERE rating IS NOT NULL
")->fetch(PDO::FETCH_ASSOC);

/*
|--------------------------------------------------------------------------
| Merge MPP + Emergency
|--------------------------------------------------------------------------
*/

$serviceRatings = $mppServices;

if (!empty($emergencyService["total_ulasan"])) {
    $serviceRatings[] = $emergencyService;
}

usort($serviceRatings, function ($a, $b) {
    return $b["avg_rating"] <=> $a["avg_rating"];
});

/*
|--------------------------------------------------------------------------
| Distribusi Bintang MPP
|--------------------------------------------------------------------------
*/

$mppStars = $pdo->query("
    SELECT rating, COUNT(*) jumlah
    FROM ratings
    GROUP BY rating
")->fetchAll(PDO::FETCH_KEY_PAIR);

/*
|--------------------------------------------------------------------------
| Distribusi Bintang Emergency
|--------------------------------------------------------------------------
*/

$emergencyStars = $pdo->query("
    SELECT rating, COUNT(*) jumlah
    FROM emergencies
    WHERE rating IS NOT NULL
    GROUP BY rating
")->fetchAll(PDO::FETCH_KEY_PAIR);

/*
|--------------------------------------------------------------------------
| Gabungkan Distribusi
|--------------------------------------------------------------------------
*/

$starDistribution = [];

for ($i = 1; $i <= 5; $i++) {

    $starDistribution[$i] =
        ($mppStars[$i] ?? 0)
        +
        ($emergencyStars[$i] ?? 0);

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