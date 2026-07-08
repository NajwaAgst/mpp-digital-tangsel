<?php

namespace App\Http\Controllers;

use App\Repositories\ServiceRepository;
use App\Repositories\StatsRepository;
use App\Repositories\EmergencyRepository;
use App\Repositories\ApplicationRepository;

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

                'description' =>
                    'Pengajuan seluruh layanan perizinan, administrasi kependudukan, perpajakan, kesehatan, pendidikan, dan layanan publik lainnya secara online.',

                'icon' => '🏛️',

                'color' => 'emerald',

                'url' => '/services',

                'button' => 'Masuk MPP',

                'badge' => 'Pelayanan Publik'

            ],

            [

                'title' => 'Emergency 112',

                'description' =>
                    'Layanan pelaporan keadaan darurat Kota Tangerang Selatan. Digunakan untuk kebakaran, kecelakaan, kriminalitas, bencana alam, maupun kondisi darurat lainnya.',

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

        return $this->view(

            'home',

            [

                'authUser'       => $authUser,

                'applications'   => $applications,

                'userStats'      => $userStats,

                'services'       => $services,

                'stats'          => $stats,

                'portals'        => $portals,

                'emergencyStats' => $emergencyStats

            ]

        );
    }
}