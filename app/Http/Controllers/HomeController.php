<?php

namespace App\Http\Controllers;

use App\Repositories\ServiceRepository;
use App\Repositories\StatsRepository;
use App\Repositories\EmergencyRepository;

class HomeController extends Controller
{
    public function index(): string
    {
        // ==============================
        // Data seluruh layanan MPP
        // ==============================
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

        // ==============================
        // Statistik Dashboard
        // ==============================
        $stats = StatsRepository::all();

        // ==============================
        // Statistik Emergency
        // ==============================
        $emergencyStats = [

            'total'      => EmergencyRepository::count(),
            'waiting'    => EmergencyRepository::countByStatus('Menunggu'),
            'processing' => EmergencyRepository::countByStatus('Diproses'),
            'done'       => EmergencyRepository::countByStatus('Selesai'),

        ];

        // ==============================
        // Portal Utama
        // ==============================
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

        return $this->view(

            'home',

            [

                'services'       => $services,
                'stats'          => $stats,
                'portals'        => $portals,
                'emergencyStats' => $emergencyStats

            ]

        );
    }
}