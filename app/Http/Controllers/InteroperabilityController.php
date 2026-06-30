<?php

namespace App\Http\Controllers;

class InteroperabilityController extends Controller
{
    public function dukcapil(string $nik): string
    {
        $data = [
            '3674011111110001' => [
                'nik' => '3674011111110001',
                'nama' => 'Maya Salsabila',
                'alamat' => 'Jl. Serpong Raya No. 12, Tangerang Selatan',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '1991-05-14',
                'jenis_kelamin' => 'Perempuan',
            ],
        ];

        if (!isset($data[$nik])) {
            return json_encode(['success' => false, 'message' => 'Data NIK tidak ditemukan']);
        }

        usleep(450000);
        return json_encode(['success' => true, 'data' => $data[$nik], 'response_time_ms' => 450]);
    }

    public function kemenkes(string $str): string
    {
        $responses = [
            'STR-001' => [
                'success' => true,
                'response_time_ms' => 650,
                'data' => ['spesialisasi' => 'Spesialis Penyakit Dalam', 'masa_berlaku' => '2028-12-31', 'asal_universitas' => 'Universitas Indonesia', 'status' => 'Aktif']
            ],
            'STR-LAMBAT' => [
                'success' => true,
                'response_time_ms' => 4200,
                'data' => ['spesialisasi' => 'Spesialis Anak', 'masa_berlaku' => '2029-09-10', 'asal_universitas' => 'Universitas Padjadjaran', 'status' => 'Aktif']
            ],
            'STR-404' => [
                'success' => false,
                'message' => 'Nomor STR tidak ditemukan',
                'response_time_ms' => 3200,
            ],
        ];

        $response = $responses[$str] ?? ['success' => false, 'message' => 'Nomor STR tidak ditemukan', 'response_time_ms' => 3200];
        if (!empty($response['success'])) {
            usleep($response['response_time_ms'] * 1000);
        }

        return json_encode($response);
    }
}
